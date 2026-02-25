{{-- resources/views/shop/partials/product-item.blade.php --}}
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
    
    $isArabic = app()->getLocale() == 'ar';
@endphp

<div class="product-item" data-aos="fade-up">
    <div class="product-name">
        <a href="{{ route('shop.products.show', $product->slug) }}">
            {{ $product->localized_name }}
        </a>
    </div>
    
    <div class="product-description">
        {{ $product->localized_description ?? ($isArabic ? 'أرز عالي الجودة' : 'High quality rice') }}
    </div>
    
    <div class="product-meta">
        <div class="product-price">
            @if(Auth::check() && $price)
                <span class="currency">{{ $isArabic ? 'ر.س' : 'SAR' }}</span>
                {{ number_format($price->price, 2) }}
            @elseif(!Auth::check())
                <span class="text-muted" style="font-size: 0.9rem;">
                    <i class="fas fa-lock me-1"></i>
                    {{ $isArabic ? 'سجل دخول' : 'Login' }}
                </span>
            @else
                <span class="text-muted" style="font-size: 0.9rem;">
                    {{ $isArabic ? 'غير متاح' : 'N/A' }}
                </span>
            @endif
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <!-- حالة المخزون -->
            @if($stock && $stock->available_quantity > 0)
                <div class="stock-info">
                    <span class="stock-dot"></span>
                    <span>{{ number_format($stock->available_quantity) }} {{ $isArabic ? 'كجم' : 'kg' }}</span>
                </div>
            @else
                <div class="stock-info" style="color: #dc2626;">
                    <span class="stock-dot" style="background: #dc2626;"></span>
                    <span>{{ $isArabic ? 'غير متوفر' : 'Out of stock' }}</span>
                </div>
            @endif
            
            <!-- أزرار الإجراءات -->
            <div class="action-buttons">
                @if(Auth::check() && $price && $stock && $stock->available_quantity > 0)
                    <form action="{{ route('shop.cart.add') }}" method="POST" class="add-to-cart-form d-inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="{{ $product->min_order_quantity ?? 1 }}">
                        <button type="submit" class="btn-add-cart">
                            <i class="fas fa-cart-plus"></i>
                            {{ $isArabic ? 'أضف' : 'Add' }}
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('shop.products.show', $product->slug) }}" class="btn-view">
                    <i class="fas fa-eye"></i>
                    {{ $isArabic ? 'عرض' : 'View' }}
                </a>
            </div>
        </div>
    </div>
</div>