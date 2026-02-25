<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display branch manager dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        if (!$branchId) {
            return redirect()->route('dashboard')->with('error', 'لم يتم تعيين فرع لك');
        }

        // إحصائيات الفرع
        $todayOrders = Order::where('branch_id', $branchId)
            ->whereDate('created_at', today())
            ->count();

        $todayRevenue = Order::where('branch_id', $branchId)
            ->whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $pendingOrders = Order::where('branch_id', $branchId)
            ->where('status', 'pending')
            ->count();

        $monthOrders = Order::where('branch_id', $branchId)
            ->whereMonth('created_at', now()->month)
            ->count();

        // أحدث طلبات الفرع
        $recentOrders = Order::where('branch_id', $branchId)
            ->with(['user', 'branch'])
            ->latest()
            ->take(10)
            ->get();

        // تنبيهات المخزون المنخفض
        $lowStock = Stock::where('branch_id', $branchId)
            ->where('available_quantity', '<=', 10)
            ->with(['product', 'branch'])
            ->get();

        return view('branch-manager.dashboard', compact(
            'todayOrders',
            'todayRevenue',
            'pendingOrders',
            'monthOrders',
            'recentOrders',
            'lowStock'
        ));
    }
}
