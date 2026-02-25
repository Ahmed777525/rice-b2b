<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مستخدم - لوحة التحكم</title>
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
                    <a href="{{ route('admin.settings.index') }}" class="d-block text-white text-decoration-none"><i class="fas fa-cog"></i> الإعدادات</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">إضافة مستخدم جديد</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>الاسم</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>كلمة المرور</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>تأكيد كلمة المرور</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>رقم الهاتف</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>الدور</label>
                                    <select name="role" class="form-control" required>
                                        <option value="trader">تاجر</option>
                                        <option value="branch_manager">مدير فرع</option>
                                        <option value="admin">مدير نظام</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>اسم الشركة</label>
                                    <input type="text" name="company_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>السجل التجاري</label>
                                    <input type="text" name="commercial_register" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">إلغاء</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
