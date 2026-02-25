<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل الفرع - لوحة التحكم</title>
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
                    <a href="{{ route('admin.branches.index') }}" class="d-block text-white text-decoration-none mb-2"><i class="fas fa-store"></i> الفروع</a>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">فرع: {{ $branch->name }}</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr><th width="200">الاسم</th><td>{{ $branch->name }} / {{ $branch->name_en }}</td></tr>
                            <tr><th>العنوان</th><td>{{ $branch->address }}</td></tr>
                            <tr><th>العنوان (إنجليزي)</th><td>{{ $branch->address_en ?? '-' }}</td></tr>
                            <tr><th>الهاتف</th><td>{{ $branch->phone ?? '-' }}</td></tr>
                            <tr><th>البريد الإلكتروني</th><td>{{ $branch->email ?? '-' }}</td></tr>
                            <tr><th>مدير الفرع</th><td>{{ $branch->manager->name ?? '-' }}</td></tr>
                            <tr><th>الحالة</th><td>
                                @if($branch->is_active)<span class="badge bg-success">نشط</span>
                                @else<span class="badge bg-secondary">غير نشط</span>@endif
                            </td></tr>
                        </table>
                        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="btn btn-warning">تعديل</a>
                        <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">رجوع</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
