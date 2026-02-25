{{-- resources/views/welcome.blade.php --}}
@php
    $isArabic = app()->getLocale() == 'ar';
    $direction = $isArabic ? 'rtl' : 'ltr';
    $fontFamily = $isArabic ? 'Cairo, sans-serif' : 'Poppins, sans-serif';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ __('messages.company_name') }} - {{ __('messages.welcome') }}</title>
    
    <!-- Bootstrap 5 CDN -->
    @if($isArabic)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @endif
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2E7D32;
            --primary-dark: #1B5E20;
            --primary-light: #4CAF50;
            --secondary-color: #81C784;
            --accent-color: #FFB300;
            --accent-orange: #FF8F00;
            --dark-color: #1a1a2e;
            --light-color: #E8F5E9;
            --gradient-green: linear-gradient(135deg, #2E7D32 0%, #1B5E20 100%);
            --gradient-gold: linear-gradient(135deg, #FFB300 0%, #FF8F00 100%);
        }
        
        body {
            font-family: {{ $fontFamily }};
            overflow-x: hidden;
        }
        
        /* Language Switcher */
        .language-switcher {
            position: fixed;
            top: 20px;
            {{ $isArabic ? 'left: 20px;' : 'right: 20px;' }}
            z-index: 1000;
        }
        
        .language-switcher .btn {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 10px 0;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-dark) !important;
        }
        
        .navbar-brand i {
            color: var(--primary-color);
        }
        
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 15px !important;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(27,94,32,0.92), rgba(46,125,50,0.88)), 
                        url('https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 180px 0 120px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: 25px 25px;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-title .highlight {
            color: var(--accent-color);
            position: relative;
        }
        
        .hero-title .highlight::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(255,179,0,0.3);
            z-index: -1;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 35px;
            opacity: 0.95;
            line-height: 1.8;
        }
        
        .hero-buttons .btn {
            padding: 16px 45px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .hero-buttons .btn-primary {
            background: var(--gradient-gold);
            border: none;
            color: var(--dark-color);
        }
        
        .hero-buttons .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255,179,0,0.4);
        }
        
        .hero-buttons .btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
        }
        
        /* Floating Rice Animation */
        .floating-rice {
            position: absolute;
            font-size: 2rem;
            opacity: 0.2;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Stats Section */
        .stats-section {
            background: var(--gradient-green);
            padding: 50px 0;
            color: white;
            position: relative;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-gold);
        }
        
        .stat-item {
            text-align: center;
            position: relative;
        }
        
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
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            display: block;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }
        
        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: var(--light-color);
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
            position: relative;
            display: inline-block;
        }
        
        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-gold);
            border-radius: 2px;
        }
        
        .section-header p {
            color: #666;
            font-size: 1.15rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 45px 30px;
            text-align: center;
            transition: all 0.4s ease;
            border: none;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-green);
            transform: scaleX(0);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.2rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }
        
        .feature-card h4 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.8;
            font-size: 0.95rem;
        }
        
        /* Products Section */
        .products-section {
            padding: 100px 0;
            background: white;
        }
        
        .product-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            height: 100%;
            background: white;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .product-image {
            height: 220px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .product-image i {
            font-size: 5rem;
            color: var(--primary-light);
            transition: all 0.4s ease;
        }
        
        .product-card:hover .product-image i {
            transform: scale(1.2) rotate(5deg);
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            {{ $isArabic ? 'left: 15px;' : 'right: 15px;' }}
            background: var(--gradient-gold);
            color: var(--dark-color);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        
        .product-body {
            padding: 25px;
        }
        
        .product-title {
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        
        .product-desc {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .product-price {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary-color);
        }
        
        .product-price .currency {
            font-size: 1rem;
        }
        
        /* Partners Section */
        .partners-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .partner-logo {
            background: white;
            border-radius: 15px;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 120px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .partner-logo:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .partner-logo i {
            font-size: 3rem;
            color: var(--primary-light);
        }
        
        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 0;
            background: var(--gradient-green);
            position: relative;
            overflow: hidden;
        }
        
        .testimonials-section::before {
            content: '"';
            position: absolute;
            top: 50px;
            left: 10%;
            font-size: 20rem;
            color: rgba(255,255,255,0.05);
            font-family: serif;
            line-height: 1;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            position: relative;
        }
        
        .testimonial-card::before {
            content: '\201C';
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 4rem;
            color: var(--accent-color);
            font-family: serif;
            line-height: 1;
        }
        
        .testimonial-text {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #555;
            margin-bottom: 25px;
            font-style: italic;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .testimonial-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--gradient-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .testimonial-info h5 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 3px;
        }
        
        .testimonial-info p {
            color: #888;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .testimonial-stars {
            color: var(--accent-color);
            margin-bottom: 15px;
        }
        
        /* Gallery Section */
        .gallery-section {
            padding: 100px 0;
            background: white;
        }
        
        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            height: 280px;
            cursor: pointer;
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.15);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(27,94,32,0.8) 0%, transparent 100%);
            display: flex;
            align-items: flex-end;
            padding: 20px;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-overlay i {
            color: white;
            font-size: 1.5rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--gradient-gold);
            padding: 80px 0;
            text-align: center;
            color: var(--dark-color);
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 80px 0 20px;
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
            color: var(--secondary-color);
            transform: translateX(5px);
        }
        
        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        
        .footer-social a {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .footer-social a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 25px;
            margin-top: 50px;
            text-align: center;
            color: rgba(255,255,255,0.5);
        }
        
        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .stat-item::after {
                display: none;
            }
            
            .section-header h2 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-buttons .btn {
                padding: 14px 30px;
                font-size: 1rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .testimonials-section::before {
                font-size: 10rem;
            }
        }
    </style>
</head>
<body>
    <!-- Language Switcher -->
    <div class="language-switcher">
        @if($isArabic)
            <a href="{{ route('language.switch', 'en') }}" class="btn btn-light text-success">
                <i class="fas fa-globe me-2"></i>English
            </a>
        @else
            <a href="{{ route('language.switch', 'ar') }}" class="btn btn-light text-success">
                <i class="fas fa-globe me-2"></i>العربية
            </a>
        @endif
    </div>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-seedling me-2"></i>
                {{ __('messages.company_name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ $isArabic ? 'me-auto' : 'ms-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products.index') }}">{{ __('messages.products') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('messages.about') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">{{ $isArabic ? 'معرض الصور' : 'Gallery' }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">{{ __('messages.contact') }}</a>
                    </li>
                </ul>
                
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-success">
                            <i class="fas fa-user me-1"></i>
                            {{ __('messages.dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success">
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
    
    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="floating-rice" style="top: 20%; left: 10%; animation-delay: 0s;"><i class="fas fa-seedling"></i></div>
        <div class="floating-rice" style="top: 60%; left: 5%; animation-delay: 1s;"><i class="fas fa-leaf"></i></div>
        <div class="floating-rice" style="top: 30%; right: 10%; animation-delay: 2s;"><i class="fas fa-grain"></i></div>
        <div class="floating-rice" style="top: 70%; right: 5%; animation-delay: 3s;"><i class="fas fa-seedling"></i></div>
        
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="hero-title" data-aos="fade-up" data-aos-duration="1000">
                        @if($isArabic)
                            منصة الأرز للأعمال <span class="highlight">B2B</span>
                        @else
                            Rice B2B Platform <span class="highlight">For Traders</span>
                        @endif
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        @if($isArabic)
                            المنصة الرائدة في المملكة العربية السعودية لتجارة الأرز بين الشركات. نربط الموردين والموزعين في منصة موحدة وآمنة.
                        @else
                            The premier B2B platform for rice trading in Saudi Arabia. Connect with trusted suppliers and distributors in a unified and secure platform.
                        @endif
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                {{ __('messages.dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-user-plus me-2"></i>
                                {{ __('messages.register_now') }}
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                {{ __('messages.login') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">{{ $isArabic ? 'شركة منتجة' : 'Producer Companies' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">{{ $isArabic ? 'تاجر مسجل' : 'Registered Traders' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">{{ $isArabic ? 'فرع' : 'Branches' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">{{ $isArabic ? 'دعم متواصل' : 'Support' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>{{ $isArabic ? 'لماذا تختارنا؟' : 'Why Choose Us?' }}</h2>
                <p>{{ $isArabic ? 'نقدم لكم أفضل الحلول لتجارة الأرز بأعلى معايير الجودة' : 'We provide the best solutions for rice trading with the highest quality standards' }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>{{ $isArabic ? 'نظام الفروع' : 'Multi-Branch System' }}</h4>
                        <p>{{ $isArabic ? 'إدارة متعددة الفروع مع مخزون مستقل لكل فرع' : 'Manage multiple branches with independent inventory for each' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>{{ $isArabic ? 'أمنة ومدعومة' : 'Secure Payments' }}</h4>
                        <p>{{ $isArabic ? 'دعم فيزا ومدى وباي بال مع حماية كاملة' : 'Visa, Mada, and PayPal with complete protection' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>{{ $isArabic ? 'لوحة تحكم متقدمة' : 'Advanced Dashboard' }}</h4>
                        <p>{{ $isArabic ? 'تحكم كامل في الطلبات والمخزون والإحصائيات' : 'Full control over orders, inventory, and analytics' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Products Preview -->
    <section class="products-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>{{ $isArabic ? 'منتجاتنا المميزة' : 'Our Featured Products' }}</h2>
                <p>{{ $isArabic ? 'أفضل أنواع الأرز المحلي والعالمي' : 'The best local and international rice varieties' }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="product-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-image">
                            <span class="product-badge">{{ $isArabic ? 'الأكثر مبيعاً' : 'Best Seller' }}</span>
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">{{ $isArabic ? 'أرز بني عضوي' : 'Organic Brown Rice' }}</h5>
                            <p class="product-desc">{{ $isArabic ? 'أرز بني طبيعي غني بالألياف والفيتامينات' : 'Natural brown rice rich in fiber and vitamins' }}</p>
                            <div class="product-price">
                                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span> 150
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-image">
                            <span class="product-badge">{{ $isArabic ? 'جديد' : 'New' }}</span>
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">{{ $isArabic ? 'أرز بسمتي سوبر' : 'Super Basmati Rice' }}</h5>
                            <p class="product-desc">{{ $isArabic ? 'أرز بسمتي هندي طويل الحبة' : 'Long grain Indian basmati rice' }}</p>
                            <div class="product-price">
                                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span> 220
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="product-image">
                            <i class="fas fa-sun"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">{{ $isArabic ? 'أرز مصري فاخر' : 'Premium Egyptian Rice' }}</h5>
                            <p class="product-desc">{{ $isArabic ? 'أرز مصري عالي الجودة' : 'Premium quality Egyptian rice' }}</p>
                            <div class="product-price">
                                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span> 180
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-image">
                            <i class="fas fa-gem"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">{{ $isArabic ? 'أرز ياسمين' : 'Jasmin Rice' }}</h5>
                            <p class="product-desc">{{ $isArabic ? 'أرز تايلاندي عطر' : 'Fragrant Thai rice' }}</p>
                            <div class="product-price">
                                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span> 195
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-image">
                            <span class="product-badge">{{ $isArabic ? 'خصم 20%' : '20% Off' }}</span>
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">{{ $isArabic ? 'أرز حراتي' : 'Harati Rice' }}</h5>
                            <p class="product-desc">{{ $isArabic ? 'أرز محلي عالي الجودة' : 'High quality local rice' }}</p>
                            <div class="product-price">
                                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span> 120
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="product-image">
                            <i class="fas fa-water"></i>
                        </div>
                        <div class="product-body">
                            <h5 class="product-title">{{ $isArabic ? 'أرز قصير الحبوب' : 'Short Grain Rice' }}</h5>
                            <p class="product-desc">{{ $isArabic ? 'مثالي للمقبلات والحلويات' : 'Perfect for appetizers and desserts' }}</p>
                            <div class="product-price">
                                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span> 140
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('shop.products.index') }}" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-eye me-2"></i>
                    {{ $isArabic ? 'عرض جميع المنتجات' : 'View All Products' }}
                </a>
            </div>
        </div>
    </section>
    
    <!-- Partners Section -->
    <section class="partners-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>{{ $isArabic ? 'شركاؤنا' : 'Our Partners' }}</h2>
                <p>{{ $isArabic ? 'نعمل مع أفضل الشركات المحلية والعالمية' : 'We work with the best local and international companies' }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-6 col-md-2">
                    <div class="partner-logo" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-industry"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="partner-logo" data-aos="fade-up" data-aos-delay="150">
                        <i class="fas fa-factory"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="partner-logo" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-warehouse"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="partner-logo" data-aos="fade-up" data-aos-delay="250">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="partner-logo" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="partner-logo" data-aos="fade-up" data-aos-delay="350">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-header text-white" data-aos="fade-up">
                <h2>{{ $isArabic ? 'آراء عملائنا' : 'What Our Clients Say' }}</h2>
                <p class="text-white-50">{{ $isArabic ? 'شركاء نجاحنا' : 'Our success partners' }}</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">
                            @if($isArabic)
                                "منصة ممتازة لتجارة الأرز. ساعدتنا في توسيع أعمالنا والوصول إلى عملاء جدد."
                            @else
                                "Excellent platform for rice trading. Helped us expand our business and reach new customers."
                            @endif
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">ع</div>
                            <div class="testimonial-info">
                                <h5>{{ $isArabic ? 'أحمد محمد' : 'Ahmed Mohammed' }}</h5>
                                <p>{{ $isArabic ? 'مدير مشتريات' : 'Purchasing Manager' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">
                            @if($isArabic)
                                "أفضل منصة B2B للأرز. نظام الفروع ساعدنا في إدارة مخزوننا بكفاءة."
                            @else
                                "The best B2B rice platform. The branch system helped us manage our inventory efficiently."
                            @endif
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">س</div>
                            <div class="testimonial-info">
                                <h5>{{ $isArabic ? 'سعيد الغامدي' : 'Saed Al-Ghamdi' }}</h5>
                                <p>{{ $isArabic ? 'مالك شركة توزيع' : 'Distribution Owner' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text">
                            @if($isArabic)
                                "خدمة عملاء ممتازة ومنصة سهلة الاستخدام. أنصح بها لكل التجار."
                            @else
                                "Excellent customer service and easy to use platform. I recommend it to all traders."
                            @endif
                        </p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">خ</div>
                            <div class="testimonial-info">
                                <h5>{{ $isArabic ? 'خالد العتيبي' : 'Khaled Al-Otaibi' }}</h5>
                                <p>{{ $isArabic ? 'تاجر أرز' : 'Rice Trader' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Gallery Section -->
    <section class="gallery-section" id="gallery">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>{{ $isArabic ? 'معرض الصور' : 'Photo Gallery' }}</h2>
                <p>{{ $isArabic ? 'لحظات من رحلتنا' : 'Moments from our journey' }}</p>
            </div>
            
            <div class="row g-3">
                <div class="col-md-4 col-6">
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="100">
                        <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Rice Field">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="200">
                        <img src="https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Rice Products">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="300">
                        <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Warehouse">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="100">
                        <img src="https://images.unsplash.com/photo-1604719312566-8912e9227c6a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Packing">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="200">
                        <img src="https://images.unsplash.com/photo-1506976785307-8732e854ad03?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Delivery">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="300">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Team">
                        <div class="gallery-overlay">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container cta-content">
            <h2 data-aos="fade-up">{{ $isArabic ? 'ابدأ تجارتك الآن' : 'Start Your Business Now' }}</h2>
            <p data-aos="fade-up" data-aos-delay="100">
                @if($isArabic)
                    انضم إلى منصتنا وابدأ بتجارة الأرز مع أفضل الموردين
                @else
                    Join our platform and start trading rice with the best suppliers
                @endif
            </p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-dark btn-lg px-5" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    {{ __('messages.dashboard') }}
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-dark btn-lg px-5" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-user-plus me-2"></i>
                    {{ __('messages.register_now') }}
                </a>
            @endauth
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <span class="footer-brand">
                        <i class="fas fa-seedling me-2"></i>
                        {{ __('messages.company_name') }}
                    </span>
                    <div class="footer-about">
                        <p>
                            {{ $isArabic 
                                ? 'المنصة الأولى في المملكة العربية السعودية لتجارة الأرز بين الشركات. نوفر منتجات أرز عالية الجودة من أفضل الموردين.' 
                                : 'The first platform in Saudi Arabia for B2B rice trading. We provide high-quality rice products from the best suppliers.' }}
                        </p>
                    </div>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-links">
                        <h5>{{ $isArabic ? 'روابط سريعة' : 'Quick Links' }}</h5>
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
                        <h5>{{ $isArabic ? 'تواصل معنا' : 'Contact Us' }}</h5>
                        <ul>
                            <li><a href="#"><i class="fas fa-phone me-2"></i>+966 55 123 4567</a></li>
                            <li><a href="#"><i class="fas fa-envelope me-2"></i>info@riceb2b.com</a></li>
                            <li><a href="#"><i class="fas fa-map-marker-alt me-2"></i>{{ $isArabic ? 'الرياض، المملكة العربية السعودية' : 'Riyadh, Saudi Arabia' }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ __('messages.company_name') }}. {{ __('messages.copyright') }}</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>