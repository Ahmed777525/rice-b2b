<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * @var string|null API Key للتطوير
     */
    protected ?string $apiKey;
    
    /**
     * @var string بيئة التشغيل (sandbox/live)
     */
    protected string $environment;
    
    /**
     * @var array إعدادات الطرق الدفعية
     */
    protected array $paymentMethods = [
        'visa' => [
            'name' => 'Visa',
            'name_ar' => 'فيزا',
            'enabled' => true,
            'gateway' => 'moyasar',
            'icon' => 'fab fa-cc-visa',
            'color' => '#1A1F71'
        ],
        'mada' => [
            'name' => 'Mada',
            'name_ar' => 'مدى',
            'enabled' => true,
            'gateway' => 'moyasar',
            'icon' => 'fas fa-credit-card',
            'color' => '#FF5A00'
        ],
        'paypal' => [
            'name' => 'PayPal',
            'name_ar' => 'باي بال',
            'enabled' => true,
            'gateway' => 'paypal',
            'icon' => 'fab fa-paypal',
            'color' => '#003087'
        ]
    ];

    public function __construct()
    {
        // إعدادات Moyasar (بوابة الدفع السعودية)
        $this->apiKey = config('services.moyasar.api_key', 'live_api_key');
        $this->environment = config('services.moyasar.environment', 'sandbox');
    }

    /**
     * الحصول على طرق الدفع المتاحة
     */
    public function getAvailablePaymentMethods(): array
    {
        $methods = [];
        
        foreach ($this->paymentMethods as $key => $method) {
            if ($method['enabled']) {
                $methods[$key] = $method;
            }
        }
        
        return $methods;
    }

    /**
     * إنشاء فاتورة دفع عبر Moyasar
     * 
     * @param Order $order
     * @param string $paymentMethod
     * @return array
     */
    public function createInvoice(Order $order, string $paymentMethod): array
    {
        try {
            $amount = (int) ($order->total * 100); // Moyasar uses halalas
            
            $callbackUrl = route('shop.checkout.callback');
            $callbackParams = [
                'order_id' => $order->id,
                'payment_method' => $paymentMethod
            ];
            
            $fullCallbackUrl = $callbackUrl . '?' . http_build_query($callbackParams);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($this->getApiUrl() . '/invoices', [
                'amount' => $amount,
                'currency' => 'SAR',
                'description' => "Order #{$order->order_number}",
                'callback_url' => $fullCallbackUrl,
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_method' => $paymentMethod
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // تحديث Order بـ payment_id
                $order->update([
                    'payment_id' => $data['id'],
                    'payment_method' => $paymentMethod
                ]);

                return [
                    'success' => true,
                    'payment_url' => $data['url'],
                    'invoice_id' => $data['id']
                ];
            }

            Log::error('Moyasar Invoice Creation Failed', [
                'order_id' => $order->id,
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'فشل في إنشاء فاتورة الدفع'
            ];

        } catch (\Exception $e) {
            Log::error('Payment Service Exception', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ في معالجة الدفع'
            ];
        }
    }

    /**
     * معالجة callback من بوابة الدفع
     * 
     * @param string $invoiceId
     * @return array
     */
    public function handleCallback(string $invoiceId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->getApiUrl() . '/invoices/' . $invoiceId);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'status' => $data['status'],
                    'amount' => $data['amount'] / 100,
                    'metadata' => $data['metadata'] ?? []
                ];
            }

            return [
                'success' => false,
                'message' => 'فشل في التحقق من الفاتورة'
            ];

        } catch (\Exception $e) {
            Log::error('Payment Callback Exception', [
                'invoice_id' => $invoiceId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ في التحقق من الدفع'
            ];
        }
    }

    /**
     * التحقق من حالة الدفع
     * 
     * @param Order $order
     * @return array
     */
    public function verifyPayment(Order $order): array
    {
        if (!$order->payment_id) {
            return [
                'success' => false,
                'message' => 'لا توجد عملية دفع مرتبطة'
            ];
        }

        return $this->handleCallback($order->payment_id);
    }

    /**
     * استرداد المبلغ (Refund)
     * 
     * @param Order $order
     * @param float|null $amount
     * @return array
     */
    public function refund(Order $order, ?float $amount = null): array
    {
        try {
            $refundAmount = $amount ?? $order->total;
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($this->getApiUrl() . '/refunds', [
                'amount' => (int) ($refundAmount * 100),
                'invoice_id' => $order->payment_id,
                'reason' => 'Order cancelled by customer'
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'refund_id' => $response->json()['id']
                ];
            }

            return [
                'success' => false,
                'message' => 'فشل في استرداد المبلغ'
            ];

        } catch (\Exception $e) {
            Log::error('Refund Exception', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'حدث خطأ في استرداد المبلغ'
            ];
        }
    }

    /**
     * الحصول على URL API بناءً على البيئة
     */
    protected function getApiUrl(): string
    {
        return $this->environment === 'sandbox'
            ? 'https://api.moyasar.com/v1'
            : 'https://api.moyasar.com/v1';
    }

    /**
     * التحقق من أن البيئة هي sandbox
     */
    public function isSandbox(): bool
    {
        return $this->environment === 'sandbox';
    }

    /**
     * الحصول على معلومات البوابة
     */
    public function getGatewayInfo(): array
    {
        return [
            'name' => 'Moyasar',
            'name_ar' => 'مويسر',
            'environment' => $this->environment,
            'is_sandbox' => $this->isSandbox(),
            'supported_currencies' => ['SAR', 'USD'],
            'supported_methods' => array_keys($this->getAvailablePaymentMethods())
        ];
    }
}
