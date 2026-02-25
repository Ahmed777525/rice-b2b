<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير العملاء - لوحة التحكم</title>
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
                <h2 class="mb-4">تقرير العملاء</h2>
                
                <!-- فلتر التاريخ -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.reports.customers') }}" class="row g-3">
                            <div class="col-md-4">
                                <label>من تاريخ</label>
                                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label>إلى تاريخ</label>
                                <input type="date" name="date_to" class="form-control" value="{{ $dateTo->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">بحث</button>
                                <a href="{{ route('admin.reports.customers') }}" class="btn btn-secondary">إعادة تعيين</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- إحصائيات -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5>عملاء جدد</h5>
                                <h3>{{ $newCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أفضل العملاء -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">أفضل العملاء</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>الشركة</th>
                                        <th>عدد الطلبات</th>
                                        <th>إجمالي المشتريات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCustomers as $index => $customer)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->company_name ?? '-' }}</td>
                                            <td>{{ $customer->orders_count }}</td>
                                            <td>{{ number_format($customer->total_spent, 2) }} ر.س</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد بيانات</td>
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
