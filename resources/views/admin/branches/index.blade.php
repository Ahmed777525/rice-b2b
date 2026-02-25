<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الفروع - لوحة التحكم</title>
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
        .content-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .branch-card { border: none; border-radius: 15px; transition: transform 0.3s; }
        .branch-card:hover { transform: translateY(-5px); }
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
                    <a href="{{ route('admin.branches.index') }}" class="active"><i class="fas fa-store"></i><span>الفروع</span></a>
                    <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>المستخدمون</span></a>
                    <a href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar"></i><span>التقارير</span></a>
                    <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i><span>الإعدادات</span></a>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-store me-2"></i>الفروع</h2>
                    <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>إضافة فرع
                    </a>
                </div>

                <div class="row">
                    @forelse($branches as $branch)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card branch-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $branch->name }}</h5>
                                        <small class="text-muted">{{ $branch->name_en ?? '-' }}</small>
                                    </div>
                                    @if($branch->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                    {{ $branch->address ?? '-' }}
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    {{ $branch->phone ?? '-' }}
                                </div>
                                <div class="mb-3">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    {{ $branch->email ?? '-' }}
                                </div>
                                <div class="mb-3">
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    {{ $branch->manager->name ?? 'لم يُعين' }}
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info">
                                        <i class="fas fa-shopping-cart me-1"></i>{{ $branch->orders_count }} طلب
                                    </span>
                                    <div>
                                        <a href="{{ route('admin.branches.show', $branch->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-store fa-3x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد فروع</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $branches->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
