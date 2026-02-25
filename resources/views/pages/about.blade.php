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
        
        /* Navbar - White like welcome page */
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
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, rgba(27,94,32,0.92), rgba(46,125,50,0.88)), 
                        url('https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            padding: 180px 0 80px;
            margin-top: 70px;
        }
        
        .page-header h1 { font-size: 3rem; font-weight: 800; color: white; margin-bottom: 10px; }
        .page-header p { font-size: 1.2rem; color: rgba(255,255,255,0.9); }
        .breadcrumb-item a { color: rgba(255,255,255,0.7) !important; text-decoration: none; }
        .breadcrumb-item.active { color: white !important; }
        
        /* About Section */
        .about-section { padding: 80px 0; }
        .about-image { border-radius: 25px; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.15); height: 450px; background: linear-gradient(135deg, var(--light-color), var(--primary-light)); display: flex; align-items: center; justify-content: center; position: relative; }
        .about-image::before { content: ''; position: absolute; top: 20px; left: 20px; right: 20px; bottom: 20px; border: 3px solid var(--accent-gold); border-radius: 15px; }
        .about-image i { font-size: 10rem; color: var(--primary-color); }
        .about-content h2 { font-size: 2.5rem; font-weight: 800; color: var(--primary-dark); margin-bottom: 25px; position: relative; }
        .about-content h2::after { content: ''; position: absolute; bottom: -10px; left: 0; width: 80px; height: 4px; background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange)); border-radius: 2px; }
        .about-content p { color: #666; line-height: 1.9; margin-bottom: 20px; font-size: 1.1rem; }
        
        /* Stats Section */
        .stats-section { background: linear-gradient(135deg, var(--primary-dark), var(--primary-color)); padding: 60px 0; color: white; }
        .stats-section::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--accent-gold), var(--accent-orange)); }
        .stat-item { text-align: center; position: relative; }
        .stat-item::after { content: ''; position: absolute; right: 0; top: 50%; transform: translateY(-50%); height: 50px; width: 1px; background: rgba(255,255,255,0.2); }
        .stat-item:last-child::after { display: none; }
        .stat-number { font-size: 3rem; font-weight: 800; display: block; background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-label { font-size: 1rem; opacity: 0.9; font-weight: 600; }
        
        /* Vision Mission */
        .vision-mission { padding: 80px 0; background: var(--light-color); }
        .vm-card { background: white; border-radius: 25px; padding: 50px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.08); height: 100%; border-top: 5px solid var(--primary-color); transition: all 0.4s ease; }
        .vm-card:hover { transform: translateY(-10px); box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
        .vm-card.vision { border-top-color: var(--accent-gold); }
        .vm-card i { font-size: 4rem; color: var(--primary-color); margin-bottom: 25px; }
        .vm-card.vision i { color: var(--accent-gold); }
        .vm-card h3 { font-size: 1.8rem; font-weight: 800; color: var(--primary-dark); margin-bottom: 20px; }
        .vm-card p { color: #666; line-height: 1.9; font-size: 1.1rem; }
        
        /* Features */
        .features-grid { padding: 80px 0; background: white; }
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header h2 { font-size: 2.5rem; font-weight: 800; color: var(--primary-dark); margin-bottom: 15px; }
        .section-header h2::after { content: ''; display: block; width: 80px; height: 4px; background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange)); margin: 15px auto 0; border-radius: 2px; }
        .feature-item { background: white; border-radius: 20px; padding: 45px 30px; text-align: center; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.05); height: 100%; border: 1px solid #eee; }
        .feature-item:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.12); border-color: var(--primary-color); }
        .feature-icon { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 2.2rem; color: white; transition: all 0.3s ease; }
        .feature-item:hover .feature-icon { transform: scale(1.1); box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4); }
        .feature-item h4 { color: var(--primary-dark); font-weight: 700; margin-bottom: 15px; font-size: 1.3rem; }
        .feature-item p { color: #666; line-height: 1.8; }
        
        /* Footer */
        footer { background: var(--dark-color); color: white; padding: 80px 0 20px; }
        .footer-brand { font-size: 2rem; font-weight: 800; color: var(--secondary-color); margin-bottom: 20px; display: block; }
        .footer-brand i { color: var(--primary-light); }
        .footer-about p { color: rgba(255,255,255,0.7); line-height: 1.8; }
        .footer-links h5 { color: var(--secondary-color); font-weight: 700; margin-bottom: 25px; font-size: 1.2rem; }
        .footer-links ul { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: rgba(255,255,255,0.7); text-decoration: none; transition: all 0.3s ease; display: inline-block; }
        .footer-links a:hover { color: var(--secondary-color); transform: translateX(5px); }
        .footer-social { display: flex; gap: 12px; margin-top: 20px; }
        .footer-social a { width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
        .footer-social a:hover { background: var(--primary-color); transform: translateY(-3px); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 25px; margin-top: 50px; text-align: center; color: rgba(255,255,255,0.5); }
        
        @media (max-width: 768px) {
            .page-header h1 { font-size: 2rem; }
            .about-image { height: 300px; }
            .stat-item::after { display: none; }
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
    
    <!-- Navbar - White like welcome page -->
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
                <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products.index') }}">{{ __('messages.products') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('messages.about') }}</a>
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
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.about') }}</li>
                </ol>
            </nav>
            <h1>{{ __('messages.about') }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'تعرف على قصتنا ورؤيتنا' : 'Learn about our story and vision' }}</p>
        </div>
    </section>
    
    <!-- About Section -->
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
                        <h2>{{ app()->getLocale() == 'ar' ? 'من نحن' : 'About Us' }}</h2>
                        <p>
                            {{ app()->getLocale() == 'ar' 
                                ? 'نحن شركة رائدة في مجال إنتاج وتعبئة وتوزيع الأرز في المملكة العربية السعودية. تأسست الشركة برؤية واضحة لتقديم منتجات أرز عالية الجودة تلبي احتياجات السوق المحلي والإقليمي.' 
                                : 'We are a leading company in rice production, packaging, and distribution in the Kingdom of Saudi Arabia.' }}
                        </p>
                        <p>
                            {{ app()->getLocale() == 'ar' 
                                ? 'نفخر بفريق عمل متخصص وخبرة تزيد عن 20 عاماً في صناعة الأرز. نلتزم بأعلى معايير الجودة والسلامة الغذائية.' 
                                : 'We take pride in a specialized team and over 20 years of experience in the rice industry.' }}
                        </p>
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
                        <span class="stat-number">20+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'سنة خبرة' : 'Years' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'شركة شريكة' : 'Partners' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'عميل' : 'Clients' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">{{ app()->getLocale() == 'ar' ? 'فرع' : 'Branches' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Vision Mission -->
    <section class="vision-mission">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="vm-card vision" data-aos="fade-up">
                        <i class="fas fa-eye"></i>
                        <h3>{{ app()->getLocale() == 'ar' ? 'رؤيتنا' : 'Our Vision' }}</h3>
                        <p>{{ app()->getLocale() == 'ar' ? 'أن نكون الشركة الرائدة في مجال تجارة الأرز على مستوى المنطقة.' : 'To be the leading company in rice trading in the region.' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vm-card" data-aos="fade-up">
                        <i class="fas fa-bullseye"></i>
                        <h3>{{ app()->getLocale() == 'ar' ? 'رسالتنا' : 'Our Mission' }}</h3>
                        <p>{{ app()->getLocale() == 'ar' ? 'تقديم منتجات أرز عالية الجودة بأسعار تنافسية.' : 'Providing high-quality rice products at competitive prices.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features -->
    <section class="features-grid">
        <div class="container">
            <div class="section-header">
                <h2>{{ app()->getLocale() == 'ar' ? 'لماذا نحن؟' : 'Why Choose Us?' }}</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-award"></i></div>
                        <h4>{{ app()->getLocale() == 'ar' ? 'جودة عالية' : 'High Quality' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'منتجات حاصلة على شهادات الجودة العالمية' : 'Products with international quality certifications' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                        <h4>{{ app()->getLocale() == 'ar' ? 'توصيل سريع' : 'Fast Delivery' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'توصيل لجميع الفروع في الوقت المحدد' : 'Delivery to all branches on time' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-headset"></i></div>
                        <h4>{{ app()->getLocale() == 'ar' ? 'دعم متواصل' : '24/7 Support' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'فريق دعم متاح على مدار الساعة' : 'Support team available around the clock' }}</p>
                    </div>
                </div>
            </div>
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
                        <p>{{ app()->getLocale() == 'ar' ? 'المنصة الأولى في المملكة العربية السعودية لتجارة الأرز بين الشركات.' : 'The first platform in Saudi Arabia for B2B rice trading.' }}</p>
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
                            <li><a href="#"><i class="fas fa-map-marker-alt me-2"></i>{{ app()->getLocale() == 'ar' ? 'الرياض' : 'Riyadh' }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ __('messages.company_name') }}. {{ __('messages.copyright') }}</p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
        
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
