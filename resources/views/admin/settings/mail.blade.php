<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعدادات البريد - لوحة التحكم</title>
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
                <h2 class="mb-4">إعدادات البريد الإلكتروني</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.mail') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Driver</label>
                                <select name="mail_driver" class="form-control">
                                    <option value="smtp" {{ setting()->get('mail_driver') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="mailgun" {{ setting()->get('mail_driver') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                    <option value="sendmail" {{ setting()->get('mail_driver') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Host</label>
                                <input type="text" name="mail_host" class="form-control" value="{{ setting()->get('mail_host', '') }}">
                            </div>
                            <div class="mb-3">
                                <label>Port</label>
                                <input type="number" name="mail_port" class="form-control" value="{{ setting()->get('mail_port', 587) }}">
                            </div>
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="mail_username" class="form-control" value="{{ setting()->get('mail_username', '') }}">
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="mail_password" class="form-control" placeholder="اتركه فارغاً إذا لا تريد تغييره">
                            </div>
                            <div class="mb-3">
                                <label>From Address</label>
                                <input type="email" name="mail_from_address" class="form-control" value="{{ setting()->get('mail_from_address', '') }}">
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
