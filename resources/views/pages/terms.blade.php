<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }} - {{ __('messages.company_name') }}</title>
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #2E7D32; --primary-dark: #1B5E20; --accent-gold: #FFB300; --dark-color: #1a1a2e; }
        body { font-family: 'Cairo', sans-serif; background: #f5f7fa; }
        .page-header { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%); padding: 120px 0 60px; margin-top: 70px; }
        .page-header h1 { color: white; font-weight: 800; }
        .content-section { padding: 60px 0; }
        .content-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .content-card h2 { color: var(--primary-dark); margin-bottom: 20px; font-weight: 700; }
        .content-card h3 { color: var(--primary-color); margin-top: 30px; margin-bottom: 15px; font-weight: 600; }
        .content-card p, .content-card li { color: #555; line-height: 1.8; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);">
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
            <h1>{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}</h1>
        </div>
    </section>
    
    <section class="content-section">
        <div class="container">
            <div class="content-card">
                @if(app()->getLocale() == 'ar')
                    <h2>الشروط والأحكام</h2>
                    <p>مرحباً بك في موقع الأرز للأعمال. باستخدامك لهذا الموقع، فأنت توافق على الالتزام بالشروط والأحكام التالية.</p>
                    <h3>1. الاستخدام</h3>
                    <p>يتيح لك الموقع استخدام خدماتنا حصرياً لأغراض تجارية مشروعة.</p>
                    <h3>2. الحسابات</h3>
                    <p>أنت مسؤول عن الحفاظ على سرية حسابك وكلمة المرور.</p>
                    <h3>3. الطلبات</h3>
                    <p>جميع الطلبات تخضع للموافقة وفقاً لسياسة الشركة.</p>
                    <h3>4. الأسعار والدفع</h3>
                    <p>الأسعار المذكورة تشمل الضريبة وقد تتغير دون إشعار مسبق.</p>
                    <h3>5. الإلغاء والاسترداد</h3>
                    <p>سياسة الإلغاء والاسترداد تخضع للشروط المذكورة في الموقع.</p>
                @else
                    <h2>Terms & Conditions</h2>
                    <p>Welcome to Rice B2B. By using this site, you agree to comply with the following terms and conditions.</p>
                    <h3>1. Usage</h3>
                    <p>The site allows you to use our services exclusively for legitimate business purposes.</p>
                    <h3>2. Accounts</h3>
                    <p>You are responsible for maintaining the confidentiality of your account and password.</p>
                    <h3>3. Orders</h3>
                    <p>All orders are subject to approval according to company policy.</p>
                    <h3>4. Prices and Payment</h3>
                    <p>Prices stated include VAT and may change without prior notice.</p>
                    <h3>5. Cancellation and Refund</h3>
                    <p>Cancellation and refund policy is subject to the terms stated on the site.</p>
                @endif
            </div>
        </div>
    </section>
</body>
</html>
