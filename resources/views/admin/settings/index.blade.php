<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات - لوحة التحكم</title>
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
        .settings-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .settings-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .settings-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
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
                    <a href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar"></i><span>التقارير</span></a>
                    <a href="{{ route('admin.settings.index') }}" class="active"><i class="fas fa-cog"></i><span>الإعدادات</span></a>
                </div>
            </div>
            
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">الإعدادات</h2>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="settings-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="settings-icon bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <div>
                                        <h5>إعدادات عامة</h5>
                                        <p class="text-muted mb-0">اسم التطبيق ومعلومات الاتصال</p>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('admin.settings.general') }}" class="btn btn-outline-primary">إدارة</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="settings-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="settings-icon bg-success bg-opacity-10 text-success me-3">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <div>
                                        <h5>إعدادات الفروع</h5>
                                        <p class="text-muted mb-0">الفرع الافتراضي والإعدادات</p>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('admin.settings.branches') }}" class="btn btn-outline-success">إدارة</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="settings-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="settings-icon bg-warning bg-opacity-10 text-warning me-3">
                                        <i class="fas fa-warehouse"></i>
                                    </div>
                                    <div>
                                        <h5>إعدادات المخزون</h5>
                                        <p class="text-muted mb-0">حد المخزون المنخفض والقواعد</p>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('admin.settings.stock') }}" class="btn btn-outline-warning">إدارة</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="settings-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="settings-icon bg-info bg-opacity-10 text-info me-3">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div>
                                        <h5>إعدادات الطلبات</h5>
                                        <p class="text-muted mb-0">بادئة الطلبات والتخزين</p>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('admin.settings.orders') }}" class="btn btn-outline-info">إدارة</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="settings-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="settings-icon bg-danger bg-opacity-10 text-danger me-3">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div>
                                        <h5>إعدادات الدفع</h5>
                                        <p class="text-muted mb-0">بوابات الدفع وطرق الدفع</p>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('admin.settings.payment') }}" class="btn btn-outline-danger">إدارة</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="settings-card card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="settings-icon bg-secondary bg-opacity-10 text-secondary me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h5>إعدادات البريد</h5>
                                        <p class="text-muted mb-0">إعدادات SMTP والبريد</p>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('admin.settings.mail') }}" class="btn btn-outline-secondary">إدارة</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cache Clear -->
                <div class="settings-card card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5><i class="fas fa-broom me-2"></i>مسح الكاش</h5>
                                <p class="text-muted mb-0">مسح جميع الملفات المؤقتة والمحفوظات</p>
                            </div>
                            <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-broom"></i> مسح الكاش
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
