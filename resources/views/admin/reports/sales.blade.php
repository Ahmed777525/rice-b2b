<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير المبيعات - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; background-color: #f5f6fa; }</style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-dark text-white p-0" style="min-height:100vh;">
                <div class="p-3 text-center border-bottom border-secondary">
                    <i class="fas fa-sack-grain fa-2x text-danger"></i>
                    <h5 class="mt-2">أرز性质的</h5>
                </div>
                <div class="p-3">
                    <a href="{{ route('admin.dashboard') }}" class="d-block text-white text-decoration-none mb-2"><i class="fas fa-th-large"></i> لوحة التحكم</a>
                    <a href="{{ route('admin.orders.index') }}" class="d-block text-white text-decoration-none mb-2"><i class="fas fa-shopping-cart"></i> الطلبات</a>
                    <a href="{{ route('admin.products.index') }}" class="d-block text-white text-decoration-none mb-2"><i class="fas fa-box"></i> المنتجات</a>
                    <a href="{{ route('admin.users.index') }}" class="d-block text-white text-decoration-none mb-2"><i class="fas fa-users"></i> المستخدمون</a>
                    <a href="{{ route('admin.reports.index') }}" class="d-block text-white text-decoration-none"><i class="fas fa-chart-bar"></i> التقارير</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">تقرير المبيعات</h2>
                
                <!-- فلتر التاريخ والفرع -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3">
                            <div class="col-md-3">
                                <label>من تاريخ</label>
                                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label>إلى تاريخ</label>
                                <input type="date" name="date_to" class="form-control" value="{{ $dateTo->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label>الفرع</label>
                                <select name="branch_id" class="form-control">
                                    <option value="">كل الفروع</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">بحث</button>
                                <a href="{{ route('admin.reports.sales') }}" class="btn btn-secondary">إعادة تعيين</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- إحصائيات -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>إجمالي المبيعات</h5>
                                <h3>{{ number_format($totalSales, 2) }} ر.س</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>عدد الطلبات</h5>
                                <h3>{{ $orderCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>متوسط الطلب</h5>
                                <h3>{{ number_format($averageOrder, 2) }} ر.س</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الجدول -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">الطلبات</h5>
                        <a href="{{ route('admin.reports.export-sales', ['date_from' => $dateFrom, 'date_to' => $dateTo, 'branch_id' => $branchId]) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> تصدير CSV
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>الفرع</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name ?? '-' }}</td>
                                            <td>{{ $order->branch->name ?? '-' }}</td>
                                            <td>{{ number_format($order->total, 2) }} ر.س</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">قيد الانتظار</span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-info">موافق عليه</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-primary">قيد التجهيز</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge bg-secondary">تم الشحن</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-success">مكتمل</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">ملغي</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">لا توجد طلبات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
