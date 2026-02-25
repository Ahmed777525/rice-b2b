<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعدادات الطلبات - لوحة التحكم</title>
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
                    <a href="{{ route('admin.settings.index') }}" class="d-block text-white text-decoration-none"><i class="fas fa-cog"></i> الإعدادات</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">إعدادات الطلبات</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.orders') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>بادئةرقم الطلب</label>
                                <input type="text" name="order_prefix" class="form-control" value="{{ setting()->get('order_prefix', 'ORD-') }}">
                            </div>
                            <div class="mb-3">
                                <label>الحد الأدنى للموافقة التلقائية</label>
                                <input type="number" name="auto_approve_minimum_order" class="form-control" value="{{ setting()->get('auto_approve_minimum_order', 0) }}">
                                <small class="text-muted">الطلبات أقل من هذا المبلغ ستوافق تلقائياً (0 للتعطيل)</small>
                            </div>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">رجوع</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
