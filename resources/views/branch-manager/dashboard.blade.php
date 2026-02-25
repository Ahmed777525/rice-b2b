<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الفرع - أرز الاعمال</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f6fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
        }
        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .logo i {
            font-size: 40px;
            color: #e94560;
        }
        .sidebar .logo h4 {
            margin-top: 10px;
            font-weight: 700;
        }
        .sidebar-menu {
            padding: 15px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar-menu a i {
            width: 25px;
            margin-left: 10px;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .content-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #cce5ff; color: #004085; }
        .status-processing { background: #d6d8db; color: #383d41; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .stock-alert {
            background: #fff3cd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .branch-info {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="logo">
                    <i class="fas fa-sack-grain"></i>
                    <h4>لوحة الفرع</h4>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('branch.dashboard') }}" class="active">
                        <i class="fas fa-th-large"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    <a href="{{ route('branch.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>الطلبات</span>
                    </a>
                    <a href="{{ route('branch.stocks.index') }}">
                        <i class="fas fa-warehouse"></i>
                        <span>المخزون</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger w-100 text-end" style="text-decoration: none;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Branch Info -->
                <div class="branch-info">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3><i class="fas fa-store me-2"></i>{{ Auth::user()->branch?->name ?? 'فرع غير محدد' }}</h3>
                            <p class="mb-0 opacity-75">لوحة تحكم مدير الفرع</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex align-items-center justify-content-end gap-3">
                                <span>{{ Auth::user()->name }}</span>
                                <div class="bg-white bg-opacity-25 rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="mb-1 opacity-75">طلبات اليوم</p>
                                        <h2 class="mb-0">{{ $todayOrders }}</h2>
                                    </div>
                                    <div class="stat-icon bg-white bg-opacity-25">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="mb-1 opacity-75">مبيعات اليوم</p>
                                        <h2 class="mb-0">{{ number_format($todayRevenue, 0) }}</h2>
                                        <small>ريال</small>
                                    </div>
                                    <div class="stat-icon bg-white bg-opacity-25">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card card bg-warning text-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="mb-1 opacity-75">طلبات معلقة</p>
                                        <h2 class="mb-0">{{ $pendingOrders }}</h2>
                                    </div>
                                    <div class="stat-icon bg-white bg-opacity-50">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="mb-1 opacity-75">طلبات الشهر</p>
                                        <h2 class="mb-0">{{ $monthOrders }}</h2>
                                    </div>
                                    <div class="stat-icon bg-white bg-opacity-25">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="row">
                    <!-- Orders Table -->
                    <div class="col-md-8">
                        <div class="content-card card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0"><i class="fas fa-list-alt me-2 text-primary"></i>أحدث الطلبات</h5>
                                <a href="{{ route('branch.orders.index') }}" class="btn btn-primary btn-sm">عرض الكل</a>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>م</th>
                                            <th>رقم الطلب</th>
                                            <th>العميل</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-primary">{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td class="fw-bold">{{ number_format($order->total, 2) }} ر.س</td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="status-badge status-pending">معلق</span>
                                                    @break
                                                    @case('approved')
                                                        <span class="status-badge status-approved">موافق</span>
                                                    @break
                                                    @case('processing')
                                                        <span class="status-badge status-processing">قيد التجهيز</span>
                                                    @break
                                                    @case('completed')
                                                        <span class="status-badge status-completed">مكتمل</span>
                                                    @break
                                                    @case('cancelled')
                                                        <span class="status-badge status-cancelled">ملغي</span>
                                                    @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                                لا توجد طلبات بعد
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Stock Alert -->
                        <div class="content-card card mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>تنبيهات المخزون</h5>
                            </div>
                            <div class="card-body">
                                @forelse($lowStock as $stock)
                                <div class="stock-alert">
                                    <div>
                                        <strong>{{ $stock->product->name }}</strong>
                                    </div>
                                    <span class="badge bg-danger">{{ $stock->available_quantity }}</span>
                                </div>
                                @empty
                                <div class="text-center py-3 text-success">
                                    <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                                    <p class="mb-0">المخزون جيد</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
