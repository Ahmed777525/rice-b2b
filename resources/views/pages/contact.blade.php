<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ __('messages.contact_us') }} - {{ __('messages.company_name') }}</title>
    
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
        
        /* Language Switcher */
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
        
        /* Navbar */
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
        
        /* Page Header */
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
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.5);
        }
        
        /* Contact Section */
        .contact-section {
            padding: 100px 0;
        }
        
        .contact-card {
            background: white;
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            height: 100%;
            border-top: 5px solid var(--primary-color);
        }
        
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 35px;
        }
        
        .contact-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        
        @if(app()->getLocale() == 'ar')
        .contact-icon {
            margin-left: 20px;
        }
        @else
        .contact-icon {
            margin-right: 20px;
        }
        @endif
        
        .contact-info-item:hover .contact-icon {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4);
        }
        
        .contact-icon i {
            font-size: 1.8rem;
            color: white;
        }
        
        .contact-info-text h5 {
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }
        
        .contact-info-text p {
            color: #666;
            margin: 0;
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 35px;
        }
        
        /* Contact Form */
        .contact-form {
            background: white;
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 16px 45px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(46, 125, 50, 0.4);
        }
        
        /* Map Section */
        .map-section {
            height: 450px;
            background: linear-gradient(135deg, var(--light-color), #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .map-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(46,125,50,0.1)"/></svg>');
            background-size: 20px 20px;
        }
        
        .map-section i {
            font-size: 6rem;
            color: var(--primary-color);
            position: relative;
            z-index: 2;
        }
        
        .map-section p {
            position: relative;
            z-index: 2;
            color: #666;
            margin-top: 20px;
            font-size: 1.1rem;
        }
        
        /* Footer */
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
        
        /* Alert */
        .alert-success {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .contact-card, .contact-form {
                padding: 25px;
            }
            
            .contact-info-item {
                margin-bottom: 20px;
            }
            
            .contact-icon {
                width: 55px;
                height: 55px;
            }
        }
    </style>
</head>
<body>
    <!-- Language Switcher -->
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
    
    <!-- Navbar -->
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
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.contact') }}</li>
                </ol>
            </nav>
            <h1>{{ __('messages.contact') }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'نحن هنا لمساعدتكم' : 'We are here to help you' }}</p>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="contact-card" data-aos="fade-up">
                        <h3 class="section-title">
                            {{ app()->getLocale() == 'ar' ? 'معلومات التواصل' : 'Contact Information' }}
                        </h3>
                        
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-text">
                                <h5>{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }}</h5>
                                <p>{{ app()->getLocale() == 'ar' ? 'الرياض، المملكة العربية السعودية' : 'Riyadh, Saudi Arabia' }}</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info-text">
                                <h5>{{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Phone' }}</h5>
                                <p>+966 55 123 4567</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-text">
                                <h5>{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }}</h5>
                                <p>info@riceb2b.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-info-text">
                                <h5>{{ app()->getLocale() == 'ar' ? 'أوقات العمل' : 'Working Hours' }}</h5>
                                <p>{{ app()->getLocale() == 'ar' ? 'الأحد - الخميس: 8 ص - 6 م' : 'Sun - Thu: 8 AM - 6 PM' }}</p>
                            </div>
                        </div>
                        
                        <!-- Social Media -->
                        <div class="mt-4">
                            <h5 class="mb-3">{{ app()->getLocale() == 'ar' ? 'تابعنا' : 'Follow Us' }}</h5>
                            <div class="social-icons">
                                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="contact-form" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="section-title">{{ app()->getLocale() == 'ar' ? 'أرسل لنا رسالة' : 'Send Us a Message' }}</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Name' }} *</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Phone' }} *</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الشركة' : 'Company' }}</label>
                                    <input type="text" name="company" class="form-control">
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الرسالة' : 'Message' }} *</label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        {{ app()->getLocale() == 'ar' ? 'إرسال الرسالة' : 'Send Message' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="map-section">
        <div class="text-center">
            <i class="fas fa-map-marked-alt"></i>
            <p>{{ app()->getLocale() == 'ar' ? 'الخريطة قادمة قريباً' : 'Map - Coming Soon' }}</p>
        </div>
    </section>
    
    <!-- Footer -->
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
