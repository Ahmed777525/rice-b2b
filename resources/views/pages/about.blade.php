<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ __('messages.about') }} - {{ __('messages.company_name') }}</title>
    
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2E7D32;
            --primary-dark: #1B5E20;
            --primary-light: #4CAF50;
            --secondary-color: #81C784;
            --accent-gold: #FFB300;
            --accent-orange: #FF8F00;
            --dark-color: #1a1a2e;
            --light-color: #E8F5E9;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            overflow-x: hidden;
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
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .main-navbar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            box-shadow: 0 4px 20px rgba(46, 125, 50, 0.15);
        }
        
        .navbar-brand {
            font-size: 1.6rem !important;
            font-weight: 800 !important;
            color: white !important;
        }
        
        .nav-link {
            color: white !important;
            transition: .3s ease;
            padding: 0.5rem 1rem !important;
        }
        
        .nav-link:hover {
            color: var(--accent-gold) !important;
        }
        
        .page-header {
            background: linear-gradient(135deg, rgba(27,94,32,0.92), rgba(46,125,50,0.88)), 
                        url('https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 150px 0 80px;
            position: relative;
            margin-top: 70px;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: 25px 25px;
        }
        
        .page-header .container {
            position: relative;
            z-index: 2;
        }
        
        .page-header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
        }
        
        .page-header p {
            font-size: 1.3rem;
            color: rgba(255,255,255,0.9);
        }
        
        .breadcrumb-item a {
            color: rgba(255,255,255,0.7) !important;
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: white !important;
        }
        
        .about-section {
            padding: 100px 0;
        }
        
        .about-image {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            height: 450px;
            background: linear-gradient(135deg, var(--light-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .about-image::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 3px solid var(--accent-gold);
            border-radius: 15px;
        }
        
        .about-image i {
            font-size: 10rem;
            color: var(--primary-color);
        }
        
        .about-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 25px;
            position: relative;
        }
        
        .about-content h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
            border-radius: 2px;
        }
        
        .about-content p {
            color: #666;
            line-height: 1.9;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        
        .stats-section {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            padding: 80px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-gold), var(--accent-orange));
        }
        
        .stat-item {
            text-align: center;
            position: relative;
        }
        
        @if(app()->getLocale() == 'ar')
        .stat-item::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 50px;
            width: 1px;
            background: rgba(255,255,255,0.2);
        }
        .stat-item:last-child::after {
            display: none;
        }
        @else
        .stat-item::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 50px;
            width: 1px;
            background: rgba(255,255,255,0.2);
        }
        .stat-item:last-child::after {
            display: none;
        }
        @endif
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            display: block;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 600;
        }
        
        .vision-mission {
            padding: 100px 0;
            background: var(--light-color);
        }
        
        .vm-card {
            background: white;
            border-radius: 25px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            height: 100%;
            border-top: 5px solid var(--primary-color);
            transition: all 0.4s ease;
        }
        
        .vm-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .vm-card.vision {
            border-top-color: var(--accent-gold);
        }
        
        .vm-card i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 25px;
        }
        
        .vm-card.vision i {
            color: var(--accent-gold);
        }
        
        .vm-card h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 20px;
        }
        
        .vm-card p {
            color: #666;
            line-height: 1.9;
            font-size: 1.1rem;
        }
        
        .features-grid {
            padding: 100px 0;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-header h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .section-header h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
            margin: 15px auto 0;
            border-radius: 2px;
        }
        
        .feature-item {
            background: white;
            border-radius: 20px;
            padding: 45px 30px;
            text-align: center;
            transition: all 0.4s ease;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            height: 100%;
            border: 1px solid #eee;
        }
        
        .feature-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            border-color: var(--primary-color);
        }
        
        .feature-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.2rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .feature-item:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4);
        }
        
        .feature-item h4 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .feature-item p {
            color: #666;
            line-height: 1.8;
        }
        
        .main-footer {
            background: linear-gradient(135deg, var(--dark-color) 0%, #16213e 100%);
            color: white;
            padding: 80px 0 30px;
        }
        
        .footer-brand {
            font-size: 2rem;
            font-weight: 800;
            color: var(--secondary-color);
            margin-bottom: 20px;
            display: block;
        }
        
        .footer-brand i {
            color: var(--primary-light);
        }
        
        .footer-about p {
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
        }
        
        .footer-links h5 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.2rem;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .footer-links a:hover {
            color: var(--accent-gold);
            transform: translateX(5px);
        }
        
        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        
        .social-icons a {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 25px;
            margin-top: 50px;
            text-align: center;
            color: rgba(255,255,255,0.5);
        }
        
        @media (max-width: 991px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .stat-item::after {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .about-image {
                height: 300px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .vm-card {
                padding: 30px;
            }
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
    
    <nav class="navbar navbar-expand-lg main-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-seedling me-2"></i>
                {{ __('messages.company_name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> {{ __('messages.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products.index') }}">
                            <i class="fas fa-box-open me-1"></i> {{ __('messages.products') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i> {{ __('messages.about') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i> {{ __('messages.contact') }}
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-light text-success">
                            <i class="fas fa-user me-1"></i>
                            {{ __('messages.dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            {{ __('messages.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-warning text-dark">
                            <i class="fas fa-user-plus me-1"></i>
                            {{ __('messages.register') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.about') }}</li>
                </ol>
            </nav>
            <h1>{{ __('messages.about') }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'تعرف على قصتنا ورؤيتنا' : 'Learn about our story and vision' }}</p>
        </div>
    </section>
    
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-image" data-aos="fade-up">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content" data-aos="fade-up" data-aos-delay="200">
                        <h2>
                            @if(app()->getLocale() == 'ar')
                                من نحن
                            @else
                                About Us
                            @endif
                        </h2>
                        <p>
                            @if(app()->getLocale() == 'ar')
                                نحن شركة رائدة في مجال إنتاج وتعبئة وتوزيع الأرز في المملكة العربية السعودية. تأسست الشركة برؤية واضحة لتقديم منتجات أرز عالية الجودة تلبي احتياجات السوق المحلي والإقليمي.
                            @else
                                We are a leading company in rice production, packaging, and distribution in the Kingdom of Saudi Arabia. The company was founded with a clear vision to provide high-quality rice products that meet the needs of the local and regional market.
                            @endif
                        </p>
                        <p>
                            @if(app()->getLocale() == 'ar')
                                نفخر بفريق عمل متخصص وخبرة تزيد عن 20 عاماً في صناعة الأرز. نلتزم بأعلى معايير الجودة والسلامة الغذائية في جميع مراحل الإنتاج والتعبئة والتوزيع.
                            @else
                                We take pride in a specialized team and over 20 years of experience in the rice industry. We are committed to the highest standards of quality and food safety at all stages of production, packaging, and distribution.
                            @endif
                        </p>
                        <p>
                            @if(app()->getLocale() == 'ar')
                                اليوم، نخدم مئات العملاء عبر منصتنا B2B المبتكرة، نربط الموردين والموزعين في منصة موحدة وفعالة.
                            @else
                                Today, we serve hundreds of clients through our innovative B2B platform, connecting suppliers and distributors in a unified and efficient platform.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                        <span class="stat-number">20+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'سنة خبرة' : 'Years Experience' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'شركة شريكة' : 'Partner Companies' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'عميل مسجل' : 'Registered Clients' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'فرع' : 'Branches' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="vision-mission">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="vm-card vision" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-eye"></i>
                        <h3>{{ app()->getLocale() == 'ar' ? 'رؤيتنا' : 'Our Vision' }}</h3>
                        <p>
                            @if(app()->getLocale() == 'ar')
                                أن نكون الشركة الرائدة في مجال تجارة الأرز على مستوى المنطقة، نقدم حلولاً مبتكرة تلبي احتياجات عملائنا المتطورة ونساهم في تحقيق الأمن الغذائي.
                            @else
                                To be the leading company in rice trading in the region, providing innovative solutions that meet the evolving needs of our clients and contributing to food security.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vm-card" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-bullseye"></i>
                        <h3>{{ app()->getLocale() == 'ar' ? 'رسالتنا' : 'Our Mission' }}</h3>
                        <p>
                            @if(app()->getLocale() == 'ar')
                                تقديم منتجات أرز عالية الجودة بأسعار تنافسية، مع ضمان أعلى مستويات الخدمة لعملائنا وبناء شراكات طويلة الأمد تخدم أهداف جميع الأطراف.
                            @else
                                Providing high-quality rice products at competitive prices, while ensuring the highest levels of service for our clients and building long-term partnerships that serve the goals of all parties.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="features-grid">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>{{ app()->getLocale() == 'ar' ? 'لماذا نحن؟' : 'Why Choose Us?' }}</h2>
                <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'نقدم لكم أفضل الحلول لتجارة الأرز' : 'We provide the best solutions for rice trading' }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>{{ app()->getLocale() == 'ar' ? 'جودة عالية' : 'High Quality' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'منتجات أرز حاصلة على شهادات الجودة العالمية' : 'Rice products with international quality certifications' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>{{ app()->getLocale() == 'ar' ? 'توصيل سريع' : 'Fast Delivery' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'توصيل لجميع الفروع في الوقت المحدد' : 'Delivery to all branches on time' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>{{ app()->getLocale() == 'ar' ? 'دعم متواصل' : '24/7 Support' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'فريق دعم متاح على مدار الساعة' : 'Support team available around the clock' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="main-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <span class="footer-brand">
                        <i class="fas fa-seedling me-2"></i>
                        {{ __('messages.company_name') }}
                    </span>
                    <div class="footer-about">
                        <p>
                            {{ app()->getLocale() == 'ar' 
                                ? 'المنصة الأولى في المملكة العربية السعودية لتجارة الأرز بين الشركات. نوفر منتجات أرز عالية الجودة من أفضل الموردين.' 
                                : 'The first platform in Saudi Arabia for B2B rice trading. We provide high-quality rice products from the best suppliers.' }}
                        </p>
                    </div>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-links">
                        <h5>{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h5>
                        <ul>
                            <li><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                            <li><a href="{{ route('shop.products.index') }}">{{ __('messages.products') }}</a></li>
                            <li><a href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-links">
                        <h5>{{ app()->getLocale() == 'ar' ? 'تواصل معنا' : 'Contact Us' }}</h5>
                        <ul>
                            <li><a href="#"><i class="fas fa-phone me-2"></i>+966 55 123 4567</a></li>
                            <li><a href="#"><i class="fas fa-envelope me-2"></i>info@riceb2b.com</a></li>
                            <li><a href="#"><i class="fas fa-map-marker-alt me-2"></i>{{ app()->getLocale() == 'ar' ? 'الرياض، المملكة العربية السعودية' : 'Riyadh, Saudi Arabia' }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} {{ __('messages.company_name') }}. {{ __('messages.copyright') }}</p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>
