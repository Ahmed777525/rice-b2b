<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * قائمة جميع الطلبات
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'branch']);

        // فلترة حسب الحالة
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // فلترة حسب فرع
        if ($request->has('branch_id') && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // فلترة حسب تاريخ
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // البحث
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(20);
        $branches = \App\Models\Branch::all();

        return view('admin.orders.index', compact('orders', 'branches'));
    }

    /**
     * تفاصيل الطلب
     */
    public function show($id)
    {
        $order = Order::with(['user', 'branch', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * الموافقة على الطلب (تخصم المخزون)
     */
    public function approve($id)
    {
        $result = $this->orderService->approveOrder($id);

        if ($result['success']) {
            return back()->with('success', __('messages.order_approved_successfully'));
        }

        return back()->with('error', __("messages.{$result['message']}"));
    }

    /**
     * رفض الطلب (إلغاء الحجز)
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $result = $this->orderService->rejectOrder($id, $request->reason);

        if ($result['success']) {
            return back()->with('success', __('messages.order_rejected_successfully'));
        }

        return back()->with('error', __("messages.{$result['message']}"));
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,processing,shipped,completed,cancelled,rejected'
        ]);

        $order = Order::findOrFail($id);
        
        // التحقق من صحة الانتقال
        $validTransitions = [
            'pending' => ['approved', 'rejected', 'cancelled'],
            'approved' => ['processing', 'cancelled'],
            'processing' => ['shipped'],
            'shipped' => ['completed'],
        ];

        if (!isset($validTransitions[$order->status]) || 
            !in_array($request->status, $validTransitions[$order->status])) {
            return back()->with('error', 'لا يمكن تغيير الحالة بهذه الطريقة');
        }

        $order->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الطلب');
    }

    /**
     * تصدير الطلبات
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'branch']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        // إنشاء CSV
        $csvData = [];
        $csvData[] = ['رقم الطلب', 'العميل', 'الفرع', 'الإجمالي', 'الحالة', 'تاريخ الإنشاء'];

        foreach ($orders as $order) {
            $csvData[] = [
                $order->order_number,
                $order->user->name,
                $order->branch->name,
                $order->total,
                $order->status,
                $order->created_at->format('Y-m-d H:i')
            ];
        }

        $filename = 'orders_' . now()->format('Y-m-d') . '.csv';
        
        $handle = fopen('php://temp', 'r+');
        foreach ($csvData as $line) {
            fputcsv($handle, $line);
        }
        rewind($handle);
        
        return response()->streamDownload(function() use($handle) {
            fpassthru($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
