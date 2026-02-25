<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $paymentService;

    public function __construct(
        CartService $cartService,
        OrderService $orderService,
        PaymentService $paymentService
    ) {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    /**
     * عرض صفحة Checkout
     */
    public function index()
    {
        $cart = $this->cartService->getCart();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart.index')
                ->with('error', __('messages.cart_is_empty'));
        }

        $paymentMethods = $this->paymentService->getAvailablePaymentMethods();
        $gatewayInfo = $this->paymentService->getGatewayInfo();

        return view('shop.checkout.index', compact('cart', 'paymentMethods', 'gatewayInfo'));
    }

/**
     * معالجة الطلب والدفع
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:visa,mada,paypal,cod',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cart = $this->cartService->getCart();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart.index')
                ->with('error', __('messages.cart_is_empty'));
        }

        // التحقق من توفر المخزون (للتأكيد فقط - سيتم الخصم عند الموافقة)
        foreach ($cart->items as $item) {
            $stock = $item->product->stocks()
                ->where('branch_id', $cart->branch_id)
                ->first();

            if (!$stock || $stock->available_quantity < $item->quantity) {
                return back()->with('error', 
                    __('messages.insufficient_stock_for_product', [
                        'product' => $item->product->name
                    ])
                );
            }
        }

        // إنشاء الطلب بحالة pending
        $order = $this->orderService->createOrder([
            'notes' => $request->notes,
            'payment_method' => $request->payment_method
        ]);

        if (!$order) {
            return back()->with('error', 'فشل في إنشاء الطلب');
        }

        // معالجة الدفع عند الاستلام (COD)
        if ($request->payment_method === 'cod') {
            // تحديث حالة الدفع أنها pending (سيتم التحقق عند الاستلام)
            $order->update([
                'payment_status' => 'pending',
                'status' => 'pending' // الطلب في انتظار الموافقة
            ]);

            // مسح السلة
            $this->cartService->clearCart();

            // توجيه لصفحة نجاح الطلب
            return redirect()->route('shop.checkout.success', $order->id)
                ->with('success', __('messages.order_created_successfully'));
        }

        // للدفع الإلكتروني - إنشاء فاتورة دفع
        $paymentResult = $this->paymentService->createInvoice(
            $order,
            $request->payment_method
        );

        if (!$paymentResult['success']) {
            // في حالة الفشل، نقوم بإلغاء الطلب
            $order->update(['status' => 'cancelled']);
            
            return back()->with('error', $paymentResult['message']);
        }

        // توجيه المستخدم لصفحة الدفع
        return redirect($paymentResult['payment_url']);
    }

    /**
     * معالجة callback من بوابة الدفع
     */
    public function callback(Request $request)
    {
        $invoiceId = $request->query('id');
        $orderId = $request->query('order_id');
        
        if (!$invoiceId || !$orderId) {
            return redirect()->route('dashboard')
                ->with('error', 'بيانات الدفع غير صحيحة');
        }

        // التحقق من حالة الدفع
        $paymentResult = $this->paymentService->handleCallback($invoiceId);

        if (!$paymentResult['success']) {
            return redirect()->route('shop.orders.show', $orderId)
                ->with('error', $paymentResult['message']);
        }

        // الحصول على الطلب
        $order = $this->orderService->getOrderDetails($orderId);

        if (!$order) {
            return redirect()->route('dashboard')
                ->with('error', 'الطلب غير موجود');
        }

        // تحديث حالة الطلب بناءً على حالة الدفع
        $status = $paymentResult['status'];
        
        if ($status === 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'approved' // Approved after payment
            ]);

            return redirect()->route('shop.checkout.success', $order->id);
        } elseif ($status === 'failed') {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled'
            ]);

            return redirect()->route('shop.checkout.index')
                ->with('error', 'فشل في عملية الدفع');
        }

        // حالة أخرى (expired, etc)
        return redirect()->route('shop.orders.show', $order->id);
    }

    /**
     * عرض صفحة النجاح بعد الدفع
     */
    public function success($orderId)
    {
        $order = $this->orderService->getOrderDetails($orderId);

        if (!$order) {
            return redirect()->route('dashboard');
        }

        // التحقق من أن الطلب للمستخدم الحالي
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('dashboard');
        }

        // مسح السلة
        $this->cartService->clearCart();

        return view('shop.checkout.success', compact('order'));
    }
}
