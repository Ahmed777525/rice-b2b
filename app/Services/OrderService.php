<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Alias for createOrderFromCart
    public function createOrder(array $checkoutData): ?Order
    {
        $result = $this->createOrderFromCart($checkoutData);
        
        if ($result['success']) {
            return $result['order'];
        }
        
        return null;
    }

    /**
     * إنشاء طلب جديد من السلة
     */
    public function createOrderFromCart(array $checkoutData): array
    {
        return DB::transaction(function () use ($checkoutData) {
            $user = Auth::user();
            $cart = $this->cartService->getCurrentCart();
            
            if (!$cart || $cart->items->isEmpty()) {
                return ['success' => false, 'message' => 'cart_is_empty'];
            }
            
            // التحقق النهائي من المخزون
            foreach ($cart->items as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->where('branch_id', $cart->branch_id)
                    ->first();
                
                if (!$stock || $stock->available_quantity < $item->quantity) {
                    return [
                        'success' => false, 
                        'message' => 'insufficient_stock_for_product',
                        'product' => $item->product->localized_name
                    ];
                }
            }
            
            // إنشاء رقم الطلب
            $orderNumber = Order::generateOrderNumber();
            
// تحديد طريقة الدفع
            $paymentMethod = $checkoutData['payment_method'] ?? 'visa';
            
            // تحديد حالة الدفع بناءً على طريقة الدفع
            $paymentStatus = ($paymentMethod === 'cod') ? 'pending' : 'pending';
            $orderStatus = 'pending'; // جميع الطلبات تبدأ كـ pending للموافقة

            // إنشاء الطلب
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'branch_id' => $cart->branch_id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone' => $user->phone,
                'company_name' => $user->company_name,
                'commercial_register' => $user->commercial_register,
                'shipping_address' => $checkoutData['shipping_address'] ?? $user->address ?? 'غير محدد',
                'shipping_city' => $checkoutData['shipping_city'] ?? null,
                'shipping_phone' => $checkoutData['shipping_phone'] ?? $user->phone,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'status' => $orderStatus,
                'subtotal' => $cart->subtotal,
                'tax' => $cart->tax,
                'shipping_cost' => $checkoutData['shipping_cost'] ?? 0,
                'discount' => $checkoutData['discount'] ?? 0,
                'total' => $cart->total + ($checkoutData['shipping_cost'] ?? 0) - ($checkoutData['discount'] ?? 0),
                'notes' => $checkoutData['notes'] ?? null,
            ]);
            
            // إنشاء عناصر الطلب
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->localized_name,
                    'product_sku' => $item->product->sku,
                    'product_unit' => $item->product->unit,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'wholesale_price' => $item->wholesale_price,
                    'is_wholesale' => $item->is_wholesale,
                    'subtotal' => $item->subtotal,
                    'tax' => $item->tax,
                    'total' => $item->total,
                    'product_snapshot' => $item->product_snapshot,
                ]);
                
                // ملاحظة: المخزون محجوز مسبقاً في السلة (reserve)
                // لا يتم خصمه من المخزون الفعلي إلا بعد موافقة المدير
                // انظر طريقة approveOrder()
            }
            
            // تفريغ السلة
            $cart->clear();
            
            // تسجيل العملية
            Log::info('Order created', ['order_id' => $order->id, 'order_number' => $orderNumber]);
            
            return [
                'success' => true,
                'message' => 'order_created_successfully',
                'order' => $order->load('items'),
                'order_number' => $orderNumber
            ];
        });
    }

    /**
     * الحصول على طلبات المستخدم
     */
    public function getUserOrders()
    {
        $user = Auth::user();
        
        return Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * الحصول على تفاصيل طلب معين
     */
    public function getOrderDetails(int $orderId)
    {
        $user = Auth::user();
        
        $order = Order::with('items')
            ->where('user_id', $user->id)
            ->where('id', $orderId)
            ->firstOrFail();
        
        return $order;
    }

    /**
     * إلغاء طلب
     */
    public function cancelOrder(int $orderId, string $reason = null): array
    {
        return DB::transaction(function () use ($orderId, $reason) {
            $user = Auth::user();
            $order = Order::where('user_id', $user->id)
                ->where('id', $orderId)
                ->firstOrFail();
            
            if (!$order->canBeCancelled()) {
                return [
                    'success' => false,
                    'message' => 'order_cannot_be_cancelled'
                ];
            }
            
            // إعادة الكميات للمخزون (إلغاء الحجز)
            foreach ($order->items as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->where('branch_id', $order->branch_id)
                    ->first();
                
                if ($stock) {
                    $stock->unreserve($item->quantity);
                }
            }
            
            $order->updateStatus('cancelled', $reason);
            
            return [
                'success' => true,
                'message' => 'order_cancelled_successfully'
            ];
        });
    }

    /**
     * موافقة مدير الفرع على الطلب (Approval-Based Stock Deduction)
     * يتم خصم المخزون الفعلي بعد موافقة المدير
     */
    public function approveOrder(int $orderId, ?string $notes = null): array
    {
        return DB::transaction(function () use ($orderId, $notes) {
            $order = Order::with('items')->findOrFail($orderId);
            
            if (!$order->canBeApproved()) {
                return ['success' => false, 'message' => 'order_cannot_be_approved'];
            }
            
            // التحقق من توفر المخزون
            foreach ($order->items as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->where('branch_id', $order->branch_id)->first();
                
                if (!$stock || $stock->available_quantity < $item->quantity) {
                    return ['success' => false, 'message' => 'insufficient_stock', 'product' => $item->product_name];
                }
            }
            
            // خصم المخزون الفعلي
            foreach ($order->items as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->where('branch_id', $order->branch_id)->first();
                
                if ($stock) {
                    $stock->quantity -= $item->quantity;
                    $stock->reserved_quantity -= $item->quantity;
                    $stock->save();
                }
            }
            
            $order->updateStatus('approved');
            if ($notes) {
                $order->admin_notes = $notes;
                $order->save();
            }
            
            Log::info('Order approved', ['order_id' => $order->id, 'order_number' => $order->order_number]);
            
            return ['success' => true, 'message' => 'order_approved_successfully', 'order' => $order];
        });
    }

    /**
     * رفض الطلب
     */
    public function rejectOrder(int $orderId, string $reason): array
    {
        return DB::transaction(function () use ($orderId, $reason) {
            $order = Order::findOrFail($orderId);
            
            if ($order->status !== 'pending') {
                return ['success' => false, 'message' => 'order_cannot_be_rejected'];
            }
            
            // إعادة الكميات المحجوزة
            foreach ($order->items as $item) {
                $stock = Stock::where('product_id', $item->product_id)
                    ->where('branch_id', $order->branch_id)->first();
                
                if ($stock) {
                    $stock->unreserve($item->quantity);
                }
            }
            
            $order->updateStatus('rejected', $reason);
            
            return ['success' => true, 'message' => 'order_rejected_successfully'];
        });
    }
}
