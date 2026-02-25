<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المنتجات - لوحة التحكم</title>
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="logo">
                    <i class="fas fa-sack-grain"></i>
                    <h4>ارز الاعمال</h4>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-th-large"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>الطلبات</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="active">
                        <i class="fas fa-box"></i>
                        <span>المنتجات</span>
                    </a>
                    <a href="{{ route('admin.stocks.index') }}">
                        <i class="fas fa-warehouse"></i>
                        <span>المخزون</span>
                    </a>
                    <a href="{{ route('admin.branches.index') }}">
                        <i class="fas fa-store"></i>
                        <span>الفروع</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>المستخدمون</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>التقارير</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i>
                        <span>الإعدادات</span>
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>المنتجات</h2>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة منتج
                    </a>
                </div>
                
                <div class="content-card card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>اسم المنتج</th>
                                    <th>SKU</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->prices->first() ? number_format($product->prices->first()->price, 2) . ' ر.س' : '-' }}</td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-secondary">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">لا توجد منتجات</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
