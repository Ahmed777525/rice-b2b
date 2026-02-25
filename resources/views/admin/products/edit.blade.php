<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل منتج - لوحة التحكم</title>
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
                    <a href="{{ route('admin.products.index') }}" class="active"><i class="fas fa-box"></i><span>المنتجات</span></a>
                    <a href="{{ route('admin.stocks.index') }}"><i class="fas fa-warehouse"></i><span>المخزون</span></a>
                    <a href="{{ route('admin.branches.index') }}"><i class="fas fa-store"></i><span>الفروع</span></a>
                    <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>المستخدمون</span></a>
                    <a href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar"></i><span>التقارير</span></a>
                    <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i><span>الإعدادات</span></a>
                </div>
            </div>
            
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">تعديل منتج</h2>
                
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>اسم المنتج</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>رمز المنتج (SKU)</label>
                                    <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>الوصف</label>
                                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>السعر</label>
                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}" step="0.01" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>الحالة</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ $product->is_active ? 'selected' : '' }}>نشط</option>
                                        <option value="0" {{ !$product->is_active ? 'selected' : '' }}>غير نشط</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">تحديث</button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
