<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل فرع - لوحة التحكم</title>
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
                <h2 class="mb-4">تعديل الفرع</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>اسم الفرع</label>
                                    <input type="text" name="name" class="form-control" value="{{ $branch->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>اسم الفرع (إنجليزي)</label>
                                    <input type="text" name="name_en" class="form-control" value="{{ $branch->name_en }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>العنوان</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ $branch->address }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label>العنوان (إنجليزي)</label>
                                <textarea name="address_en" class="form-control" rows="2">{{ $branch->address_en }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>رقم الهاتف</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $branch->phone }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control" value="{{ $branch->email }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>مدير الفرع</label>
                                <select name="manager_id" class="form-control">
                                    <option value="">اختر مدير</option>
                                    @foreach($managers ?? [] as $manager)
                                        <option value="{{ $manager->id }}" {{ $branch->manager_id == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $branch->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">نشط</label>
                            </div>
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">إلغاء</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
