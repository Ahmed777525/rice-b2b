@extends('shop.layouts.shop-new')

@php
    use Illuminate\Support\Facades\Auth;
    $isArabic = app()->getLocale() == 'ar';
@endphp

@section('title', __('messages.products'))

@section('content')
<!-- Page Header -->
<div class="bg-white rounded-3 shadow-sm p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="fas fa-boxes text-success fs-5"></i>
            </div>
            <div>
                <h4 class="fw-bold text-success mb-0">{{ $isArabic ? 'المنتجات' : 'Products' }}</h4>
                <small class="text-success">{{ $isArabic ? 'تصفح مجموعتنا الكاملة' : 'Browse our collection' }}</small>
            </div>
        </div>
        <div class="bg-success bg-opacity-10 text-success px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-cubes me-2"></i>
            {{ $products->count() ?? 0 }} {{ $isArabic ? 'منتج' : 'Products' }}
        </div>
    </div>
</div>

<!-- Category Filters -->
@if(isset($categories) && $categories->count() > 0)
<div class="mb-4">
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('shop.products.index') }}" 
           class="btn {{ !request('category') ? 'btn-success' : 'btn-outline-success' }} rounded-pill">
            {{ $isArabic ? 'الكل' : 'All' }}
        </a>
        @foreach($categories as $category)
        <a href="{{ route('shop.products.index', ['category' => $category->id]) }}" 
           class="btn {{ request('category') == $category->id ? 'btn-success' : 'btn-outline-success' }} rounded-pill">
            {{ $category->localized_name }}
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
        @php
            $userBranchId = Auth::check() ? Auth::user()->branch_id : null;
            
            $price = null;
            if ($userBranchId) {
                $price = $product->getPriceForBranch($userBranchId);
            }
            if (!$price) {
                $price = $product->prices()->where('is_active', true)->first();
            }
            
            $stock = null;
            if ($userBranchId) {
                $stock = $product->getStockForBranch($userBranchId);
            }
            if (!$stock) {
                $totalStock = $product->stocks()->sum('available_quantity');
                $stock = new \stdClass();
                $stock->available_quantity = $totalStock;
            }
            
            $isNew = $product->created_at->diffInDays(now()) <= 7;
        @endphp

        <!-- Product Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);">
                <!-- Product Image -->
                <div class="position-relative bg-light p-5 text-center" style="height: 180px;">
                    @if($isNew)
                    <span class="position-absolute top-0 {{ $isArabic ? 'start-0' : 'end-0'}} m-2 badge bg-success">
                        {{ $isArabic ? 'جديد' : 'NEW' }}
                    </span>
                    @endif
                    <i class="fas fa-sack-grain text-secondary" style="font-size: 4rem; opacity: 0.5;"></i>
                </div>

                <!-- Product Body -->
                <div class="card-body p-4">
                    <!-- Category -->
                    <small class="text-success fw-bold text-uppercase">
                        <i class="fas fa-tag me-1"></i>
                        {{ $product->category?->localized_name ?? '---' }}
                    </small>

                    <!-- Title -->
                    <h5 class="fw-bold my-3" style="color: #1a5632;">
                        <a href="{{ route('shop.products.show', $product->slug) }}" class="text-decoration-none" style="color: inherit;">
                            {{ $product->localized_name }}
                        </a>
                    </h5>

                    <!-- Stock Status -->
                    <div class="d-flex align-items-center gap-2 py-2 border-top border-bottom border-secondary border-opacity-25 mb-3">
                        <span class="rounded-circle {{ $stock && $stock->available_quantity > 0 ? 'bg-success' : 'bg-danger' }}" style="width: 10px; height: 10px;"></span>
                        <small class="{{ $stock && $stock->available_quantity > 0 ? 'text-secondary' : 'text-danger' }}">
                            <strong>{{ number_format($stock->available_quantity ?? 0) }}</strong> {{ $isArabic ? 'كجم متوفر' : 'KG Available' }}
                        </small>
                    </div>

                    <!-- Price Section -->
                    @if(Auth::check() && $price)
                        <div class="mb-3">
                            <span class="fs-3 fw-bold text-success">{{ number_format($price->price, 2) }}</span>
                            <small class="text-success fw-bold">{{ $isArabic ? 'ر.س' : 'SAR' }}</small>
                        </div>

                        @if($stock && $stock->available_quantity > 0)
                            <form action="{{ route('shop.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="{{ $product->min_order_quantity ?? 1 }}">
                                <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2 add-to-cart-btn">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    {{ $isArabic ? 'أضف للسلة' : 'Add to Cart' }}
                                </button>
                            </form>
                        @else
                            <div class="btn btn-danger w-100 fw-bold rounded-pill py-2 opacity-75">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $isArabic ? 'غير متوفر' : 'Out of Stock' }}
                            </div>
                        @endif

                        <a href="{{ route('shop.products.show', $product->slug) }}" class="d-block text-center mt-3 text-success text-decoration-none fw-bold">
                            <i class="fas fa-eye me-1"></i>
                            {{ $isArabic ? 'عرض التفاصيل' : 'View Details' }}
                        </a>
                    @elseif(Auth::check())
                        <div class="bg-light text-secondary rounded-pill py-2 text-center mb-3 fw-bold">
                            <i class="fas fa-ban me-2"></i>
                            {{ $isArabic ? 'السعر غير متاح' : 'Price not available' }}
                        </div>
                    @else
                        <div class="bg-info bg-opacity-10 text-info rounded-pill py-2 text-center mb-3 fw-bold">
                            <i class="fas fa-lock me-2"></i>
                            {{ $isArabic ? 'سجل دخول لعرض السعر' : 'Login to view price' }}
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-success w-100 fw-bold rounded-pill py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            {{ $isArabic ? 'تسجيل الدخول' : 'Login' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'links'))
    <div class="mt-5 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-white rounded-3 shadow-sm p-5 text-center">
        <i class="fas fa-box-open text-secondary fs-1 mb-3 d-block" style="opacity: 0.5;"></i>
        <h5 class="fw-bold">{{ $isArabic ? 'لا توجد منتجات' : 'No Products Found' }}</h5>
        <p class="text-secondary">{{ $isArabic ? 'سيتم إضافة منتجات قريباً' : 'Products will be added soon' }}</p>
        <a href="{{ route('home') }}" class="btn btn-success rounded-pill px-4">
            <i class="fas fa-home me-2"></i>
            {{ $isArabic ? 'العودة للرئيسية' : 'Back to Home' }}
        </a>
    </div>
@endif

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[action*="cart/add"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('button');
            const originalHTML = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            try {
                await new Promise(resolve => setTimeout(resolve, 800));
                
                btn.innerHTML = '<i class="fas fa-check"></i> {{ $isArabic ? "تمت الإضافة" : "Added" }}';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-warning', 'text-dark');
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.add('btn-success');
                    btn.classList.remove('btn-warning', 'text-dark');
                    btn.disabled = false;
                }, 2000);
                
            } catch (error) {
                btn.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-danger');
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.add('btn-success');
                    btn.classList.remove('btn-danger');
                    btn.disabled = false;
                }, 2000);
            }
        });
    });
});
</script>
@endsection
