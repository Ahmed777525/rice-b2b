<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * عرض قائمة الطلبات
     */
    public function index()
    {
        $orders = $this->orderService->getUserOrders();
        
        return view('shop.orders.index', compact('orders'));
    }

    /**
     * عرض تفاصيل طلب معين
     */
    public function show($id)
    {
        $order = $this->orderService->getOrderDetails($id);
        
        return view('shop.orders.show', compact('order'));
    }

    /**
     * إلغاء طلب
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);
        
        $result = $this->orderService->cancelOrder($id, $request->reason);
        
        if ($result['success']) {
            return redirect()->route('shop.orders.index')
                ->with('success', __('messages.order_cancelled_successfully'));
        }
        
        return back()->with('error', __("messages.{$result['message']}"));
    }

    /**
     * طباعة فاتورة الطلب
     */
    public function invoice($id)
    {
        $order = $this->orderService->getOrderDetails($id);
        
        return view('shop.orders.invoice', compact('order'));
    }
}
