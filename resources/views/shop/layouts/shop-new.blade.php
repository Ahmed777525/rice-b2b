<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - {{ __('messages.company_name') }}</title>
    
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
        }
        
        body {
            font-family: 'Cairo', sans-serif !important;
            background-color: #f5f7fa !important;
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
        
        .cart-icon-wrap {
            position: relative;
            font-size: 0.95rem;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            {{ app()->getLocale() == 'ar' ? 'right: -8px;' : 'left: -8px;' }}
            background: var(--accent-orange);
            color: #fff;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: bold;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .dropdown-item {
            padding: 10px 15px;
        }
        
        .dropdown-item:hover {
            background: var(--primary-light);
            color: #fff;
        }
        
        /* Footer - Same as welcome page */
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
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }
    </style>
    @stack('styles')
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
                
                <div class="d-flex gap-2 align-items-center">
                    <a class="nav-link cart-icon-wrap" href="{{ route('shop.cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="cartCountBadge">0</span>
                    </a>
                    
                    @auth
                        <div class="dropdown">
                            <a class="btn btn-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>{{ __('messages.dashboard') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('shop.orders.index') }}"><i class="fas fa-shopping-bag me-2"></i>{{ __('messages.my_orders') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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

    <!-- Main Content -->
    <main class="min-vh-100 py-4" style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer - Same as welcome page -->
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
                            {{ app()->getLocale() == 'ar' 
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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
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
        
        // Update Cart Count
        function updateCartCount() {
            fetch('{{ route("shop.cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cartCountBadge').textContent = data.count;
                })
                .catch(error => console.error('Error:', error));
        }
        
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
    
    @stack('scripts')
</body>
</html>
