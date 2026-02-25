<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * لوحة التقارير
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * تقرير المبيعات
     */
    public function sales(Request $request)
    {
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth();
        $dateTo = $request->date_to ?? Carbon::now()->endOfDay();
        $branchId = $request->branch_id;

        $query = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('status', '!=', 'cancelled');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $orders = $query->with(['user', 'branch'])->get();
        $totalSales = $orders->sum('total');
        $orderCount = $orders->count();
        $averageOrder = $orderCount > 0 ? $totalSales / $orderCount : 0;

        // المبيعات اليومية
        $dailySales = $orders->groupBy(function($order) {
            return $order->created_at->format('Y-m-d');
        })->map(function($dayOrders) {
            return $dayOrders->sum('total');
        });

        $branches = \App\Models\Branch::all();

        return view('admin.reports.sales', compact(
            'orders', 'totalSales', 'orderCount', 'averageOrder', 
            'dailySales', 'branches', 'dateFrom', 'dateTo', 'branchId'
        ));
    }

    /**
     * تقرير المنتجات
     */
    public function products(Request $request)
    {
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth();
        $dateTo = $request->date_to ?? Carbon::now()->endOfDay();

        // أكثر المنتجات مبيعاً - استخدام unit_price بدلاً من price
        $topProducts = \DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.id',
                'products.name',
                \DB::raw('SUM(order_items.quantity) as total_sold'),
                \DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // المخزون المنخفض - استخدام reorder_level بدلاً من min_stock_level
        $lowStock = Stock::with(['product', 'branch'])
            ->whereRaw('quantity - reserved_quantity <= reorder_level')
            ->get();

        return view('admin.reports.products', compact('topProducts', 'lowStock', 'dateFrom', 'dateTo'));
    }

    /**
     * تقرير العملاء
     */
    public function customers(Request $request)
    {
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth();
        $dateTo = $request->date_to ?? Carbon::now()->endOfDay();

        // أفضل العملاء
        $topCustomers = User::where('role', 'trader')
            ->withCount(['orders' => function($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('status', '!=', 'cancelled');
            }])
            ->with(['orders' => function($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('status', '!=', 'cancelled');
            }])
            ->get()
            ->map(function($user) {
                $user->total_spent = $user->orders->sum('total');
                return $user;
            })
            ->sortByDesc('total_spent')
            ->take(10);

        // عملاء جدد
        $newCustomers = User::where('role', 'trader')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        return view('admin.reports.customers', compact('topCustomers', 'newCustomers', 'dateFrom', 'dateTo'));
    }

    /**
     * تصدير تقرير المبيعات
     */
    public function exportSales(Request $request)
    {
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth();
        $dateTo = $request->date_to ?? Carbon::now()->endOfDay();

        $orders = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('status', '!=', 'cancelled')
            ->with(['user', 'branch'])
            ->get();

        $csvData = [];
        $csvData[] = ['رقم الطلب', 'العميل', 'الفرع', 'المبلغ', 'الحالة', 'التاريخ'];

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

        $filename = 'sales_report_' . now()->format('Y-m-d') . '.csv';
        
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
