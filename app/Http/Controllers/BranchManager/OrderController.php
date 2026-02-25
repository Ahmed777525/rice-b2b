<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display branch orders
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        if (!$branchId) {
            return redirect()->route('branch.dashboard')->with('error', 'لم يتم تعيين فرع لك');
        }

        $query = Order::where('branch_id', $branchId)
            ->with(['user', 'branch']);

        // Filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('phone', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('branch-manager.orders.index', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show($id)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $order = Order::where('id', $id)
            ->where('branch_id', $branchId)
            ->with(['user', 'branch', 'items.product'])
            ->firstOrFail();

        return view('branch-manager.orders.show', compact('order'));
    }

    /**
     * Approve order
     */
    public function approve($id)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $order = Order::where('id', $id)
            ->where('branch_id', $branchId)
            ->where('status', 'pending')
            ->firstOrFail();

        $result = $this->orderService->approveOrder($order);

        if ($result['success']) {
            return redirect()->route('branch.orders.show', $id)->with('success', 'تم الموافقة على الطلب بنجاح');
        }

        return redirect()->route('branch.orders.show', $id)->with('error', $result['message']);
    }

    /**
     * Reject order
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $request->validate([
            'reason' => 'required|string|min:10'
        ]);

        $order = Order::where('id', $id)
            ->where('branch_id', $branchId)
            ->where('status', 'pending')
            ->firstOrFail();

        $result = $this->orderService->rejectOrder($order, $request->reason);

        if ($result['success']) {
            return redirect()->route('branch.orders.index')->with('success', 'تم رفض الطلب بنجاح');
        }

        return redirect()->route('branch.orders.show', $id)->with('error', $result['message']);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $request->validate([
            'status' => 'required|in:processing,shipped,completed'
        ]);

        $order = Order::where('id', $id)
            ->where('branch_id', $branchId)
            ->whereIn('status', ['approved', 'processing', 'shipped'])
            ->firstOrFail();

        $result = $this->orderService->updateStatus($order, $request->status);

        if ($result['success']) {
            return redirect()->route('branch.orders.show', $id)->with('success', 'تم تحديث حالة الطلب بنجاح');
        }

        return redirect()->route('branch.orders.show', $id)->with('error', $result['message']);
    }
}
