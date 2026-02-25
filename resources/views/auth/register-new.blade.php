<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ __('messages.register') }} - {{ __('messages.company_name') }}</title>
    
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0d6efd;
            --dark: #212529;
            --light: #f8f9fa;
            --border: #dee2e6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 40px 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .register-container {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 1;
        }
        
        .register-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 45px 40px;
            text-align: center;
            position: relative;
        }
        
        .register-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.2), rgba(15, 52, 96, 0.3));
        }
        
        .register-header > * {
            position: relative;
            z-index: 1;
        }
        
        .header-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .register-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 8px;
        }
        
        .register-header p {
            opacity: 0.8;
            font-size: 1rem;
        }
        
        .b2b-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: #000;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-top: 15px;
        }
        
        .register-body {
            padding: 40px;
        }
        
        .form-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            padding: 14px 18px;
            border: 2px solid var(--border);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(26, 26, 46, 0.3);
        }
        
        .login-prompt {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--border);
            color: #6c757d;
        }
        
        .login-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        
        .login-prompt a:hover {
            text-decoration: underline;
        }
        
        .language-switch {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10;
        }
        
        .language-switch a {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 18px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .language-switch a:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a2e;
            margin: 25px 0 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary);
        }
        
        /* Alert */
        .alert-danger {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        
        @media (max-width: 576px) {
            .register-header {
                padding: 35px 25px;
            }
            
            .register-body {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Language Switcher -->
    <div class="language-switch">
        @if(app()->getLocale() == 'ar')
            <a href="{{ route('language.switch', 'en') }}"><i class="fas fa-globe me-1"></i> English</a>
        @else
            <a href="{{ route('language.switch', 'ar') }}"><i class="fas fa-globe me-1"></i> العربية</a>
        @endif
    </div>

    <div class="register-container">
        <!-- Header -->
        <div class="register-header">
            <div class="header-icon">
                <i class="fas fa-seedling"></i>
            </div>
            <h2>{{ __('messages.company_name') }}</h2>
            <p>{{ app()->getLocale() == 'ar' ? 'منصة تجارة الأرز للأعمال B2B' : 'B2B Rice Trading Platform' }}</p>
            <span class="b2b-badge">
                <i class="fas fa-briefcase me-1"></i>
                {{ app()->getLocale() == 'ar' ? 'للتجار والموزعين فقط' : 'For Traders & Distributors Only' }}
            </span>
        </div>
        
        <!-- Body -->
        <div class="register-body">
            <div class="text-center mb-4">
                <h4 style="font-weight: 700;">{{ __('messages.register') }}</h4>
                <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'أنشئ حسابك التجاري الآن' : 'Create your business account now' }}</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Personal Info -->
                <h6 class="section-title">
                    <i class="fas fa-user"></i>
                    {{ app()->getLocale() == 'ar' ? 'المعلومات الشخصية' : 'Personal Information' }}
                </h6>

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i>{{ __('messages.full_name') }} *
                    </label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل اسمك الكامل' : 'Enter your full name' }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>{{ __('messages.email') }} *
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل بريدك الإلكتروني' : 'Enter your email' }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-2"></i>{{ __('messages.phone') }} *
                    </label>
                    <input type="text" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           required 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أرقام التواصل' : 'Contact numbers' }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Company Info -->
                <h6 class="section-title">
                    <i class="fas fa-building"></i>
                    {{ app()->getLocale() == 'ar' ? 'معلومات الشركة' : 'Company Information' }}
                </h6>

                <!-- Company Name -->
                <div class="mb-3">
                    <label for="company_name" class="form-label">
                        <i class="fas fa-building me-2"></i>{{ __('messages.company_name_field') }} *
                    </label>
                    <input type="text" 
                           class="form-control @error('company_name') is-invalid @enderror" 
                           id="company_name"
                           name="company_name" 
                           value="{{ old('company_name') }}" 
                           required 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل اسم شركتك' : 'Enter your company name' }}">
                    @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Commercial Register & Tax Number -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="commercial_register" class="form-label">
                            <i class="fas fa-file-alt me-2"></i>{{ __('messages.commercial_register') }} *
                        </label>
                        <input type="text" 
                               class="form-control @error('commercial_register') is-invalid @enderror" 
                               id="commercial_register" 
                               name="commercial_register" 
                               value="{{ old('commercial_register') }}" 
                               required 
                               placeholder="{{ app()->getLocale() == 'ar' ? 'رقم السجل التجاري' : 'Commercial Register No.' }}">
                        @error('commercial_register')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tax_number" class="form-label">
                            <i class="fas fa-receipt me-2"></i>{{ __('messages.tax_number') }}
                        </label>
                        <input type="text" 
                               class="form-control @error('tax_number') is-invalid @enderror" 
                               id="tax_number" 
                               name="tax_number" 
                               value="{{ old('tax_number') }}" 
                               placeholder="{{ app()->getLocale() == 'ar' ? 'الرقم الضريبي' : 'Tax Number' }}">
                        @error('tax_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Branch -->
                <div class="mb-3">
                    <label for="branch_id" class="form-label">
                        <i class="fas fa-store me-2"></i>{{ __('messages.select_branch') }} *
                    </label>
                    <select class="form-select @error('branch_id') is-invalid @enderror" 
                            id="branch_id" 
                            name="branch_id" 
                            required>
                        <option value="">{{ app()->getLocale() == 'ar' ? 'اختر فرع التوريد' : 'Select supply branch' }}</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }} - {{ $branch->city }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <h6 class="section-title">
                    <i class="fas fa-lock"></i>
                    {{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>{{ __('messages.password') }} *
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="{{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>{{ __('messages.confirm_password') }} *
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="{{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm password' }}">
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus me-2"></i>
                    {{ __('messages.register') }}
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-prompt">
                <p class="mb-2">{{ app()->getLocale() == 'ar' ? 'لديك حساب بالفعل؟' : 'Already have an account?' }}</p>
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    {{ app()->getLocale() == 'ar' ? 'سجل دخولك الآن' : 'Login now' }}
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
