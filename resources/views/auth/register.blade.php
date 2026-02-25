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
            --primary: #2E7D32;
            --primary-dark: #1B5E20;
            --primary-light: #4CAF50;
            --accent: #FFB300;
            --dark: #1a1a2e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #388E3C 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .register-wrapper {
            display: flex;
            width: 100%;
            max-width: 1100px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 1;
        }
        
        /* Left Side - Image */
        .register-image {
            flex: 1;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.95), rgba(46, 125, 50, 0.95)),
                        url('https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .register-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.3), rgba(46, 125, 50, 0.5));
        }
        
        .register-image > * {
            position: relative;
            z-index: 1;
        }
        
        .register-image .brand-icon {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .register-image h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
        }
        
        .register-image p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 300px;
        }
        
        /* Right Side - Form */
        .register-form-wrapper {
            flex: 1.2;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .form-header {
            margin-bottom: 25px;
            text-align: center;
        }
        
        .form-header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }
        
        .form-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 6px;
            font-size: 0.85rem;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }
        
        select.form-control {
            padding: 12px 15px;
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(27, 94, 32, 0.3);
        }
        
        .login-link {
            text-align: center;
            color: #6c757d;
            margin-top: 15px;
        }
        
        .login-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .language-switch {
            position: absolute;
            top: 20px;
            {{ app()->getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }}
            z-index: 10;
        }
        
        .language-switch a {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 18px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .language-switch a:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Alert */
        .alert-danger {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        
        /* Invalid feedback */
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 4px;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        /* Responsive */
        @media (max-width: 850px) {
            .register-wrapper {
                flex-direction: column;
            }
            
            .register-image {
                padding: 40px 30px;
                min-height: 200px;
            }
            
            .register-image h2 {
                font-size: 1.5rem;
            }
            
            .register-form-wrapper {
                padding: 30px 20px;
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

    <div class="register-wrapper">
        <!-- Left Side - Image -->
        <div class="register-image">
            <div class="brand-icon">
                <i class="fas fa-seedling"></i>
            </div>
            <h2>{{ __('messages.company_name') }}</h2>
            <p>{{ app()->getLocale() == 'ar' ? 'انضم إلى منصتنا وحقق أحلامك التجارية' : 'Join our platform and achieve your business dreams' }}</p>
        </div>
        
        <!-- Right Side - Form -->
        <div class="register-form-wrapper">
            <div class="form-header">
                <h1>{{ __('messages.register') }}</h1>
                <p>{{ app()->getLocale() == 'ar' ? 'أنشئ حسابك الجديد' : 'Create your new account' }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i>{{ __('messages.name') }} *
                    </label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل اسمك' : 'Enter your name' }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
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

                <!-- Company Name -->
                <div class="form-group">
                    <label for="company_name" class="form-label">
                        <i class="fas fa-building me-2"></i>{{ __('messages.company_name') }} *
                    </label>
                    <input type="text" 
                           class="form-control @error('company_name') is-invalid @enderror" 
                           id="company_name" 
                           name="company_name" 
                           value="{{ old('company_name') }}" 
                           required 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل اسم الشركة' : 'Enter company name' }}">
                    @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Commercial Register & Tax Number -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="commercial_register" class="form-label">
                                <i class="fas fa-file-contract me-2"></i>{{ __('messages.commercial_register') }} *
                            </label>
                            <input type="text" 
                                   class="form-control @error('commercial_register') is-invalid @enderror" 
                                   id="commercial_register" 
                                   name="commercial_register" 
                                   value="{{ old('commercial_register') }}" 
                                   required 
                                   placeholder="{{ app()->getLocale() == 'ar' ? 'رقم السجل' : 'Register No.' }}">
                            @error('commercial_register')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax_number" class="form-label">
                                <i class="fas fa-receipt me-2"></i>{{ __('messages.tax_number') }}
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="tax_number" 
                                   name="tax_number" 
                                   value="{{ old('tax_number') }}" 
                                   placeholder="{{ app()->getLocale() == 'ar' ? 'الرقم الضريبي' : 'Tax Number' }}">
                        </div>
                    </div>
                </div>

                <!-- Phone & Branch -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone me-2"></i>{{ __('messages.phone') }} *
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   required 
                                   placeholder="{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch_id" class="form-label">
                                <i class="fas fa-building me-2"></i>{{ __('messages.select_branch') }} *
                            </label>
                            <select class="form-control @error('branch_id') is-invalid @enderror" 
                                    id="branch_id" 
                                    name="branch_id" 
                                    required>
                                <option value="">-- {{ app()->getLocale() == 'ar' ? 'اختر الفرع' : 'Select Branch' }} --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->localized_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password & Confirm -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>{{ __('messages.password') }} *
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="{{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>{{ __('messages.confirm_password') }} *
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="{{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}">
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus me-2"></i>
                    {{ __('messages.register') }}
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                <p>{{ app()->getLocale() == 'ar' ? 'لديك حساب بالفعل؟' : 'Already have an account?' }}
                    <a href="{{ route('login') }}">{{ app()->getLocale() == 'ar' ? 'سجل دخول' : 'Login' }}</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
