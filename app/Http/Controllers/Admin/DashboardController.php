<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // إحصائيات اليوم
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');

        // إحصائيات الأسبوع
        $weekOrders = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $weekRevenue = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('payment_status', 'paid')
            ->sum('total');

        // إحصائيات الشهر
        $monthOrders = Order::whereMonth('created_at', now()->month)->count();
        $monthRevenue = Order::whereMonth('created_at', now()->month)
            ->where('payment_status', 'paid')
            ->sum('total');

        // الطلبات المعلقة
        $pendingOrders = Order::where('status', 'pending')->count();

        // أحدث الطلبات
        $recentOrders = Order::with(['user', 'branch'])
            ->latest()
            ->take(10)
            ->get();

        // المستخدمين الجدد هذا الشهر
        $newUsers = User::whereMonth('created_at', now()->month)->count();

        // المخزون المنخفض
        $lowStock = Stock::whereRaw('quantity <= reserved_quantity + 10')
            ->with('product', 'branch')
            ->take(10)
            ->get();

        // إحصائيات الحالات
        $orderStatusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'todayOrders',
            'todayRevenue',
            'weekOrders',
            'weekRevenue',
            'monthOrders',
            'monthRevenue',
            'pendingOrders',
            'recentOrders',
            'newUsers',
            'lowStock',
            'orderStatusCounts'
        ));
    }

    /**
     * إحصائيات بسيطة
     */
    public function stats()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_branches' => Branch::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ]);
    }
}
