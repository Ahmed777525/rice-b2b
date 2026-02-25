@extends('shop.layouts.shop-new')

@section('title', $product->localized_name)

@section('styles')
<style>
    :root {
        --primary: #0d6efd;
        --success: #198754;
        --warning: #ffc107;
        --danger: #dc3545;
        --dark: #212529;
        --light: #f8f9fa;
        --gray: #6c757d;
        --gray-dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Hero Header */
    .product-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        padding: 60px 0 40px;
        position: relative;
        overflow: hidden;
    }

    .product-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .product-hero .container {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.7) !important;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: white !important;
    }

    /* Main Image */
    .image-container {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .main-image {
        height: 450px;
        background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
    }

    .main-image:hover {
        background: linear-gradient(180deg, #e9ecef 0%, #dee2e6 100%);
    }

    .main-image-icon {
        font-size: 10rem;
        color: var(--gray);
        transition: all 0.4s ease;
    }

    .image-container:hover .main-image-icon {
        transform: scale(1.1);
        color: var(--primary);
    }

    /* Product Info */
    .product-info-card {
        background: white;
        border-radius: 24px;
        padding: 35px;
        box-shadow: var(--shadow);
    }

    .product-category {
        font-size: 0.85rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .product-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.3;
        margin-bottom: 15px;
    }

    .product-badges {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .badge-item {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .badge-sku {
        background: var(--light);
        color: var(--gray-dark);
    }

    .badge-featured {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: #000;
    }

    /* Price Block */
    .price-section {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 16px;
        padding: 25px;
        color: white;
        margin: 25px 0;
    }

    .price-label {
        font-size: 0.9rem;
        opacity: 0.7;
        margin-bottom: 5px;
    }

    .price-value {
        font-size: 2.5rem;
        font-weight: 800;
    }

    .price-currency {
        font-size: 1rem;
        opacity: 0.8;
    }

    .original-price {
        font-size: 1.2rem;
        opacity: 0.6;
        text-decoration: line-through;
        margin-left: 15px;
    }

    .discount-badge {
        background: var(--danger);
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    /* Wholesale */
    .wholesale-section {
        background: #fff9e6;
        border-radius: 16px;
        padding: 20px;
        margin-top: 15px;
    }

    .wholesale-title {
        font-weight: 700;
        color: var(--gray-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .wholesale-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    .wholesale-row:last-child {
        border-bottom: none;
    }

    .wholesale-label {
        color: var(--gray);
    }

    .wholesale-value {
        font-weight: 700;
        color: var(--success);
        font-size: 1.1rem;
    }

    /* Stock */
    .stock-section {
        margin: 20px 0;
    }

    .stock-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
    }

    .stock-available {
        background: #d4edda;
        color: #155724;
    }

    .stock-low {
        background: #fff3cd;
        color: #856404;
    }

    .stock-out {
        background: #f8d7da;
        color: #721c24;
    }

    /* Quantity */
    .quantity-section {
        margin: 25px 0;
    }

    .qty-wrapper {
        display: flex;
        align-items: center;
        background: var(--light);
        border-radius: 12px;
        overflow: hidden;
        max-width: 300px;
    }

    .qty-btn {
        width: 50px;
        height: 50px;
        border: none;
        background: var(--dark);
        color: white;
        font-size: 1.3rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .qty-btn:hover {
        background: var(--primary);
    }

    .qty-input {
        flex: 1;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
        background: transparent;
    }

    .qty-input:focus {
        outline: none;
    }

    .qty-unit {
        padding: 0 20px;
        font-weight: 600;
        color: var(--gray);
    }

    /* Buttons */
    .btn-add-cart {
        width: 100%;
        background: var(--dark);
        color: white;
        border: none;
        border-radius: 14px;
        padding: 18px 30px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-add-cart:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-add-cart:disabled {
        background: var(--gray);
        cursor: not-allowed;
    }

    /* Tabs */
    .info-tabs {
        margin-top: 40px;
    }

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        border-bottom: 2px solid var(--border);
        padding-bottom: 15px;
    }

    .tab-btn {
        padding: 12px 25px;
        border: none;
        background: transparent;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .tab-btn:hover {
        background: var(--light);
    }

    .tab-btn.active {
        background: var(--dark);
        color: white;
    }

    .tab-content {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: var(--shadow);
    }

    .description-text {
        line-height: 1.8;
        color: var(--gray-dark);
        font-size: 1.05rem;
    }

    /* Specifications */
    .specs-table {
        width: 100%;
    }

    .specs-table tr {
        border-bottom: 1px solid var(--border);
    }

    .specs-table tr:last-child {
        border-bottom: none;
    }

    .specs-table th {
        padding: 15px;
        text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        font-weight: 600;
        color: var(--gray-dark);
        width: 40%;
    }

    .specs-table td {
        padding: 15px;
        color: var(--dark);
    }

    /* Login Prompt */
    .login-prompt {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        color: white;
        margin: 25px 0;
    }

    .login-prompt h4 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .login-prompt .btn {
        background: white;
        color: #667eea;
        font-weight: 600;
        border-radius: 10px;
        padding: 12px 30px;
    }

    /* Related Products */
    .related-section {
        margin-top: 60px;
    }

    .related-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: var(--dark);
    }

    .related-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
    }

    .related-card:hover {
        transform: translateY(-8px);
    }

    .related-image {
        height: 180px;
        background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-image-icon {
        font-size: 3.5rem;
        color: var(--gray);
    }

    .related-body {
        padding: 20px;
    }

    .related-name {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .related-category {
        font-size: 0.85rem;
        color: var(--gray);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .product-title {
            font-size: 1.6rem;
        }

        .main-image {
            height: 300px;
        }

        .price-value {
            font-size: 2rem;
        }

        .tab-buttons {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Header -->
<div class="product-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.products.index') }}">{{ app()->getLocale() == 'ar' ? 'المنتجات' : 'Products' }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.products.index', ['category' => $product->category_id]) }}">{{ $product->category?->localized_name ?? '' }}</a></li>
                <li class="breadcrumb-item active">{{ $product->localized_name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="image-container">
                <div class="main-image">
                    <i class="fas fa-sack-grain main-image-icon"></i>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-info-card">
                <div class="product-category">
                    <i class="fas fa-tag me-2"></i>
                    {{ $product->category?->localized_name ?? '---' }}
                </div>

                <h1 class="product-title">{{ $product->localized_name }}</h1>

                <div class="product-badges">
                    <span class="badge-item badge-sku">
                        <i class="fas fa-barcode me-1"></i>
                        {{ $product->sku }}
                    </span>
                    @if($product->is_featured)
                        <span class="badge-item badge-featured">
                            <i class="fas fa-star me-1"></i>
                            {{ app()->getLocale() == 'ar' ? 'مميز' : 'Featured' }}
                        </span>
                    @endif
                </div>

                @auth
                    @if($price)
                        <!-- Price Section -->
                        <div class="price-section">
                            <div class="price-label">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}</div>
                            <div>
                                <span class="price-value">{{ number_format($price->final_price, 2) }}</span>
                                <span class="price-currency">{{ app()->getLocale() == 'ar' ? 'ريال' : 'SAR' }}</span>
                                @if($price->discount_percentage > 0)
                                    <span class="original-price">{{ number_format($price->price, 2) }}</span>
                                    <span class="discount-badge">-{{ $price->discount_percentage }}%</span>
                                @endif
                            </div>

                            @if($price->wholesale_price)
                                <div class="wholesale-section">
                                    <div class="wholesale-title">
                                        <i class="fas fa-tags text-warning"></i>
                                        {{ app()->getLocale() == 'ar' ? 'سعر الجملة' : 'Wholesale Price' }}
                                    </div>
                                    <div class="wholesale-row">
                                        <span class="wholesale-label">{{ app()->getLocale() == 'ar' ? 'سعر الجملة' : 'Wholesale' }}</span>
                                        <span class="wholesale-value">{{ number_format($price->wholesale_price, 2) }} {{ app()->getLocale() == 'ar' ? 'ريال' : 'SAR' }}</span>
                                    </div>
                                    <div class="wholesale-row">
                                        <span class="wholesale-label">{{ app()->getLocale() == 'ar' ? 'الحد الأدنى' : 'Min Order' }}</span>
                                        <span class="wholesale-value">{{ $price->wholesale_min_quantity }} {{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        @if($stock)
                            <div class="stock-section">
                                @if($stock->available_quantity > 0)
                                    <span class="stock-status {{ $stock->available_quantity > 10 ? 'stock-available' : 'stock-low' }}">
                                        <i class="fas fa-check-circle"></i>
                                        {{ app()->getLocale() == 'ar' ? 'متوفر' : 'Available' }}: {{ $stock->available_quantity }} {{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}
                                    </span>
                                @else
                                    <span class="stock-status stock-out">
                                        <i class="fas fa-times-circle"></i>
                                        {{ app()->getLocale() == 'ar' ? 'غير متوفر' : 'Out of Stock' }}
                                    </span>
                                @endif
                            </div>

                            <!-- Add to Cart -->
                            @if($stock->available_quantity > 0)
                                <form action="{{ route('shop.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="quantity-section">
                                        <label class="form-label fw-bold mb-2">{{ app()->getLocale() == 'ar' ? 'الكمية' : 'Quantity' }}</label>
                                        <div class="qty-wrapper">
                                            <button type="button" class="qty-btn" onclick="updateQty(this, -{{ $product->min_order_quantity }})">-</button>
                                            <input type="number" name="quantity" class="qty-input" 
                                                   value="{{ $product->min_order_quantity }}"
                                                   min="{{ $product->min_order_quantity }}"
                                                   max="{{ min($product->max_order_quantity ?? $stock->available_quantity, $stock->available_quantity) }}">
                                            <button type="button" class="qty-btn" onclick="updateQty(this, {{ $product->min_order_quantity }})">+</button>
                                            <span class="qty-unit">{{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}</span>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            {{ app()->getLocale() == 'ar' ? 'الحد الأدنى' : 'Min Order' }}: {{ $product->min_order_quantity }} {{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}
                                        </small>
                                    </div>

                                    <button type="submit" class="btn-add-cart">
                                        <i class="fas fa-cart-plus"></i>
                                        {{ app()->getLocale() == 'ar' ? 'أضف للسلة' : 'Add to Cart' }}
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ app()->getLocale() == 'ar' ? 'هذا المنتج غير متوفر حالياً' : 'This product is currently unavailable' }}
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ app()->getLocale() == 'ar' ? 'غير متوفر في فرعكم' : 'Not available in your branch' }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ app()->getLocale() == 'ar' ? 'السعر غير متوفر لهذا الفرع' : 'Price not available for this branch' }}
                        </div>
                    @endif
                @else
                    <!-- Login Prompt -->
                    <div class="login-prompt">
                        <i class="fas fa-lock fa-3x mb-3"></i>
                        <h4>{{ app()->getLocale() == 'ar' ? 'سجل دخولك للمتابعة' : 'Login to Continue' }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? 'سجل دخولك للوصول لأسعار المنتجات والشراء' : 'Login to access product prices and make purchases' }}</p>
                        <div>
                            <a href="{{ route('login') }}" class="btn">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                {{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Login' }}
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light ms-2">
                                <i class="fas fa-user-plus me-2"></i>
                                {{ app()->getLocale() == 'ar' ? 'إنشاء حساب' : 'Register' }}
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Info Tabs -->
                <div class="info-tabs">
                    <div class="tab-buttons">
                        <button class="tab-btn active" onclick="switchTab('description')">
                            <i class="fas fa-align-left me-2"></i>
                            {{ app()->getLocale() == 'ar' ? 'الوصف' : 'Description' }}
                        </button>
                        <button class="tab-btn" onclick="switchTab('specs')">
                            <i class="fas fa-list-alt me-2"></i>
                            {{ app()->getLocale() == 'ar' ? 'المواصفات' : 'Specifications' }}
                        </button>
                    </div>

                    <div class="tab-content">
                        <div id="description" class="tab-pane">
                            <p class="description-text">
                                {{ $product->localized_description ?? (app()->getLocale() == 'ar' ? 'لا يوجد وصف متاح' : 'No description available') }}
                            </p>
                        </div>

                        <div id="specs" class="tab-pane" style="display: none;">
                            <table class="specs-table">
                                <tr>
                                    <th>{{ app()->getLocale() == 'ar' ? 'الوحدة' : 'Unit' }}</th>
                                    <td>{{ $product->unit }}</td>
                                </tr>
                                <tr>
                                    <th>{{ app()->getLocale() == 'ar' ? 'الوزن' : 'Weight' }}</th>
                                    <td>{{ $product->unit_weight }} {{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ app()->getLocale() == 'ar' ? 'الحد الأدنى للطلب' : 'Min Order' }}</th>
                                    <td>{{ $product->min_order_quantity }} {{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}</td>
                                </tr>
                                @if($product->max_order_quantity)
                                <tr>
                                    <th>{{ app()->getLocale() == 'ar' ? 'الحد الأقصى للطلب' : 'Max Order' }}</th>
                                    <td>{{ $product->max_order_quantity }} {{ app()->getLocale() == 'ar' ? 'كجم' : 'KG' }}</td>
                                </tr>
                                @endif
                                @if($product->is_taxable)
                                <tr>
                                    <th>{{ app()->getLocale() == 'ar' ? 'الضريبة' : 'Tax' }}</th>
                                    <td>{{ $product->tax_rate }}% {{ app()->getLocale() == 'ar' ? 'ضريبة القيمة المضافة' : 'VAT' }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="related-section">
            <h3 class="related-title">
                <i class="fas fa-boxes me-2 text-primary"></i>
                {{ app()->getLocale() == 'ar' ? 'منتجات ذات صلة' : 'Related Products' }}
            </h3>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3">
                        <a href="{{ route('shop.products.show', $related->slug) }}" class="text-decoration-none">
                            <div class="related-card">
                                <div class="related-image">
                                    <i class="fas fa-sack-grain related-image-icon"></i>
                                </div>
                                <div class="related-body">
                                    <h6 class="related-name">{{ $related->localized_name }}</h6>
                                    <p class="related-category">{{ $related->category?->localized_name ?? '' }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function updateQty(btn, change) {
    const input = btn.parentElement.querySelector('.qty-input');
    let value = parseInt(input.value) + change;
    const min = parseInt(input.min);
    const max = parseInt(input.max);
    
    if (value >= min && value <= max) {
        input.value = value;
    }
}

function switchTab(tabName) {
    // Hide all tab content
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName).style.display = 'block';
    
    // Add active class to clicked button
    event.target.classList.add('active');
}
</script>
@endsection
