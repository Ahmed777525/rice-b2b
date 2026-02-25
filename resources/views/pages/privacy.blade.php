<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ __('messages.privacy_policy') }} - {{ __('messages.company_name') }}</title>
    
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2E7D32;
            --primary-dark: #1B5E20;
            --primary-light: #4CAF50;
            --secondary-color: #81C784;
            --accent-gold: #FFB300;
            --dark-color: #1a1a2e;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f7fa;
        }
        
        .language-switcher {
            position: fixed;
            top: 20px;
            {{ app()->getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }}
            z-index: 1000;
        }
        
        .language-switcher .btn {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            padding: 120px 0 60px;
            margin-top: 70px;
        }
        
        .page-header h1 {
            color: white;
            font-weight: 800;
        }
        
        .content-section {
            padding: 60px 0;
        }
        
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .content-card h2 {
            color: var(--primary-dark);
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .content-card h3 {
            color: var(--primary-color);
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .content-card p, .content-card li {
            color: #555;
            line-height: 1.8;
        }
        
        .main-footer {
            background: linear-gradient(135deg, var(--dark-color) 0%, #16213e 100%);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
        }
        
        .footer-links a:hover {
            color: var(--accent-gold);
        }
    </style>
</head>
<body>
    <div class="language-switcher">
        @if(app()->getLocale() == 'ar')
            <a href="{{ route('language.switch', 'en') }}" class="btn btn-light text-success">
                <i class="fas fa-globe me-2"></i>English
            </a>
        @else
            <a href="{{ route('language.switch', 'ar') }}" class="btn btn-light text-success">
                <i class="fas fa-globe me-2"></i>العربية
            </a>
        @endif
    </div>
    
    <nav class="navbar navbar-expand-lg main-navbar fixed-top" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: white !important;">
                <i class="fas fa-seedling me-2"></i>{{ __('messages.company_name') }}
            </a>
            <div class="navbar-nav {{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }}">
                <a class="nav-link" href="{{ route('home') }}" style="color: white !important;">{{ __('messages.home') }}</a>
                <a class="nav-link" href="{{ route('shop.products.index') }}" style="color: white !important;">{{ __('messages.products') }}</a>
                <a class="nav-link" href="{{ route('about') }}" style="color: white !important;">{{ __('messages.about') }}</a>
                <a class="nav-link" href="{{ route('contact') }}" style="color: white !important;">{{ __('messages.contact') }}</a>
            </div>
        </div>
    </nav>
    
    <section class="page-header">
        <div class="container">
            <h1>{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</h1>
        </div>
    </section>
    
    <section class="content-section">
        <div class="container">
            <div class="content-card">
                @if(app()->getLocale() == 'ar')
                    <h2>سياسة الخصوصية</h2>
                    <p>نحن في شركة الأرز للأعمال نقدر خصوصيتكم ونلتزم بحماية بياناتكم الشخصية. توضح هذه السياسة كيفية جمع واستخدام وحماية معلوماتكم.</p>
                    
                    <h3>1. المعلومات التي نجمعها</h3>
                    <ul>
                        <li>معلومات التسجيل (الاسم، البريد الإلكتروني، رقم الهاتف)</li>
                        <li>معلومات الشركة (السجل التجاري، الرقم الضريبي)</li>
                        <li>معلومات الطلبات والدفع</li>
                    </ul>
                    
                    <h3>2. استخدام المعلومات</h3>
                    <p>نستخدم معلوماتكم لتقديم خدماتنا، معالجة الطلبات، والتواصل معكم.</p>
                    
                    <h3>3. حماية البيانات</h3>
                    <p>نستخدم تقنيات أمان متقدمة لحماية بياناتكم الشخصية.</p>
                    
                    <h3>4. مشاركة البيانات</h3>
                    <p>لا نشارك بياناتكم مع أطراف خارجية إلا للضرورة القصوى لتقديم الخدمات.</p>
                    
                    <h3>5. حقوقكم</h3>
                    <p>لديكم الحق في الوصول والتصحيح وحذف بياناتكم الشخصية.</p>
                @else
                    <h2>Privacy Policy</h2>
                    <p>At Rice B2B, we value your privacy and are committed to protecting your personal data. This policy explains how we collect, use, and protect your information.</p>
                    
                    <h3>1. Information We Collect</h3>
                    <ul>
                        <li>Registration information (name, email, phone number)</li>
                        <li>Company information (commercial register, tax number)</li>
                        <li>Order and payment information</li>
                    </ul>
                    
                    <h3>2. Use of Information</h3>
                    <p>We use your information to provide our services, process orders, and communicate with you.</p>
                    
                    <h3>3. Data Protection</h3>
                    <p>We use advanced security technologies to protect your personal data.</p>
                    
                    <h3>4. Data Sharing</h3>
                    <p>We do not share your data with third parties except when necessary to provide services.</p>
                    
                    <h3>5. Your Rights</h3>
                    <p>You have the right to access, correct, and delete your personal data.</p>
                @endif
            </div>
        </div>
    </section>
    
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>{{ __('messages.company_name') }}</h5>
                    <p class="small" style="color: rgba(255,255,255,0.7);">
                        {{ app()->getLocale() == 'ar' ? 'المنصة الأولى في المملكة العربية السعودية لتجارة الأرز بين الشركات' : 'The first platform in Saudi Arabia for B2B rice trading' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li><a href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ __('messages.company_name') }}. {{ __('messages.copyright') }}</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
