<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name')) - {{ __('messages.products') }}</title>
    
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @endif
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: {{ app()->getLocale() == 'ar' ? 'Tahoma, Arial' : 'system-ui, -apple-system' }};
            background-color: #f8f9fa;
        }
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .price-tag {
            font-size: 1.25rem;
            font-weight: bold;
            color: #28a745;
        }
        .old-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .stock-badge {
            position: absolute;
            top: 10px;
            {{ app()->getLocale() == 'ar' ? 'left: 10px;' : 'right: 10px;' }}
        }
        .filter-sidebar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <strong>{{ __('messages.company_name') }}</strong>
            </a>
            <li class="nav-item">
    <a class="nav-link position-relative" href="{{ route('shop.cart.index') }}">
        <i class="fas fa-shopping-cart"></i> 
        {{ __('messages.cart') }}
        <span class="badge bg-success cart-count">0</span>
    </a>
</li>

<script>
// تحديث عداد السلة
function updateCartCount() {
    fetch('{{ route("shop.cart.count") }}')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = data.count;
            });
        });
}

// استدعاء عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
            
            <!-- Search Bar -->
            <form class="d-flex mx-auto" style="width: 40%;" action="{{ route('shop.products.index') }}" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="{{ __('messages.search_products') }}" value="{{ request('search') }}">
                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
            </form>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products.index') }}">{{ __('messages.products') }}</a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> {{ __('messages.dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-shopping-cart"></i> 
                                {{ __('messages.cart') }}
                                <span class="badge bg-success">0</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">{{ __('messages.profile') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('messages.orders') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">{{ __('messages.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                        </li>
                    @endauth
                    
                    <!-- Language Switcher -->
                    <li class="nav-item">
                        @if(app()->getLocale() == 'ar')
                            <a class="nav-link" href="{{ route('language.switch', 'en') }}">English</a>
                        @else
                            <a class="nav-link" href="{{ route('language.switch', 'ar') }}">العربية</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ __('messages.company_name') }}. {{ __('messages.copyright') }}</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>