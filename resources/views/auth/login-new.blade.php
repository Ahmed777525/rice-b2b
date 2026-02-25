<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ __('messages.login') }} - {{ __('messages.company_name') }}</title>
    
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
        
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 1;
        }
        
        /* Left Side - Image */
        .login-image {
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
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.3), rgba(46, 125, 50, 0.5));
        }
        
        .login-image > * {
            position: relative;
            z-index: 1;
        }
        
        .login-image .brand-icon {
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
        
        .login-image h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
        }
        
        .login-image p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 300px;
        }
        
        /* Right Side - Form */
        .login-form-wrapper {
            flex: 1;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            margin-bottom: 35px;
        }
        
        .form-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }
        
        .form-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(27, 94, 32, 0.3);
        }
        
        .form-check {
            margin: 15px 0;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .divider span {
            padding: 0 15px;
            color: #6c757d;
            font-size: 0.85rem;
        }
        
        .register-prompt {
            text-align: center;
            color: #6c757d;
        }
        
        .register-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-prompt a:hover {
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
        .alert-success {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }
        
        .alert-danger {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            
            .login-image {
                padding: 40px 30px;
                min-height: 250px;
            }
            
            .login-image h2 {
                font-size: 1.5rem;
            }
            
            .login-form-wrapper {
                padding: 35px 25px;
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

    <div class="login-wrapper">
        <!-- Left Side - Image -->
        <div class="login-image">
            <div class="brand-icon">
                <i class="fas fa-seedling"></i>
            </div>
            <h2>{{ __('messages.company_name') }}</h2>
            <p>{{ app()->getLocale() == 'ar' ? 'منصة تجارة الأرز للأعمال B2B' : 'Premium B2B Rice Trading Platform' }}</p>
        </div>
        
        <!-- Right Side - Form -->
        <div class="login-form-wrapper">
            <div class="form-header">
                <h1>{{ __('messages.login') }}</h1>
                <p>{{ app()->getLocale() == 'ar' ? 'سجل دخولك للمتابعة' : 'Sign in to continue' }}</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>{{ __('messages.email') }}
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل بريدك الإلكتروني' : 'Enter your email' }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>{{ __('messages.password') }}
                    </label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password"
                           required 
                           placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل كلمة المرور' : 'Enter your password' }}">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            {{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot password?' }}
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    {{ __('messages.login') }}
                </button>
            </form>

            <!-- Register Link -->
            <div class="divider">
                <span>{{ app()->getLocale() == 'ar' ? 'أو' : 'OR' }}</span>
            </div>

            <div class="register-prompt">
                <p class="mb-3">{{ app()->getLocale() == 'ar' ? 'ليس لديك حساب؟' : "Don't have an account?" }}</p>
                <a href="{{ route('register') }}" class="btn btn-outline-success">
                    <i class="fas fa-user-plus me-2"></i>
                    {{ __('messages.register_now') }}
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
