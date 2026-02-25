<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f5f6fa; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%); color: white; }
        .sidebar .logo { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .logo i { font-size: 40px; color: #e94560; }
        .sidebar .logo h4 { margin-top: 10px; font-weight: 700; }
        .sidebar-menu { padding: 15px; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 15px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: all 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-menu a i { width: 25px; margin-left: 10px; }
        .report-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s; }
        .report-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .report-icon { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="logo">
                    <i class="fas fa-sack-grain"></i>
                    <h4>أرز性质的</h4>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i><span>لوحة التحكم</span></a>
                    <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i><span>الطلبات</span></a>
                    <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i><span>المنتجات</span></a>
                    <a href="{{ route('admin.stocks.index') }}"><i class="fas fa-warehouse"></i><span>المخزون</span></a>
                    <a href="{{ route('admin.branches.index') }}"><i class="fas fa-store"></i><span>الفروع</span></a>
                    <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>المستخدمون</span></a>
                    <a href="{{ route('admin.reports.index') }}" class="active"><i class="fas fa-chart-bar"></i><span>التقارير</span></a>
                    <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i><span>الإعدادات</span></a>
                </div>
            </div>
            
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">التقارير</h2>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="report-card card">
                            <div class="card-body text-center py-5">
                                <div class="report-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4>تقرير المبيعات</h4>
                                <p class="text-muted">عرض تفصيلي للمبيعات اليومية والشهرية</p>
                                <a href="{{ route('admin.reports.sales') }}" class="btn btn-primary">عرض التقرير</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="report-card card">
                            <div class="card-body text-center py-5">
                                <div class="report-icon bg-success bg-opacity-10 text-success mx-auto mb-3">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h4>تقرير المنتجات</h4>
                                <p class="text-muted">أكثر المنتجات مبيعاً والمخزون المنخفض</p>
                                <a href="{{ route('admin.reports.products') }}" class="btn btn-success">عرض التقرير</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="report-card card">
                            <div class="card-body text-center py-5">
                                <div class="report-icon bg-info bg-opacity-10 text-info mx-auto mb-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>تقرير العملاء</h4>
                                <p class="text-muted">أفضل العملاء والعملاء الجدد</p>
                                <a href="{{ route('admin.reports.customers') }}" class="btn btn-info">عرض التقرير</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="report-card card">
                            <div class="card-body text-center py-5">
                                <div class="report-icon bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                                    <i class="fas fa-file-export"></i>
                                </div>
                                <h4>تصدير البيانات</h4>
                                <p class="text-muted">تصدير البيانات بصيغة Excel أو CSV</p>
                                <a href="{{ route('admin.reports.export-sales') }}" class="btn btn-warning">تصدير</a>
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
