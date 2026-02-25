@extends('shop.layouts.shop-new')

@php
    use Illuminate\Support\Facades\Auth;
    $isArabic = app()->getLocale() == 'ar';
@endphp

@section('title', __('messages.products'))

@section('content')
<!-- Page Header -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-green-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center">
                <i class="fas fa-boxes text-green-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-green-800">
                    {{ $isArabic ? 'المنتجات' : 'Products' }}
                </h1>
                <p class="text-green-600 text-sm mt-1">
                    {{ $isArabic ? 'تصفح مجموعتنا الكاملة من الأرز premium' : 'Browse our premium rice collection' }}
                </p>
            </div>
        </div>
        <div class="bg-green-50 text-green-700 px-5 py-2 rounded-full font-semibold inline-flex items-center gap-2">
            <i class="fas fa-cubes"></i>
            {{ $products->count() ?? 0 }} {{ $isArabic ? 'منتج' : 'Products' }}
        </div>
    </div>
</div>

<!-- Category Filters -->
@if(isset($categories) && $categories->count() > 0)
<div class="mb-8">
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('shop.products.index') }}" 
           class="px-4 py-2 rounded-full font-medium transition-all duration-300
                  {{ !request('category') ? 'bg-green-600 text-white shadow-lg shadow-green-600/30' : 'bg-white text-gray-600 hover:bg-green-50 border border-gray-200' }}">
            {{ $isArabic ? 'الكل' : 'All' }}
        </a>
        @foreach($categories as $category)
        <a href="{{ route('shop.products.index', ['category' => $category->id]) }}" 
           class="px-4 py-2 rounded-full font-medium transition-all duration-300
                  {{ request('category') == $category->id ? 'bg-green-600 text-white shadow-lg shadow-green-600/30' : 'bg-white text-gray-600 hover:bg-green-50 border border-gray-200' }}">
            {{ $category->localized_name }}
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col">
            <!-- Product Image -->
            <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 p-8 h-48 flex items-center justify-center overflow-hidden">
                @if($isNew)
                <span class="absolute top-3 {{ $isArabic ? 'left-3' : 'right-3'}} bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold z-10 shadow-lg">
                    <i class="fas fa-star text-xs ml-1"></i>{{ $isArabic ? 'جديد' : 'NEW' }}
                </span>
                @endif
                
                <i class="fas fa-sack-grain text-6xl text-gray-400 group-hover:text-green-600 group-hover:scale-110 transition-transform duration-300"></i>
            </div>

            <!-- Product Body -->
            <div class="p-5 flex-1 flex flex-col">
                <!-- Category -->
                <div class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-2">
                    <i class="fas fa-tag ml-1"></i>
                    {{ $product->category?->localized_name ?? ($isArabic ? 'غير مصنف' : 'Uncategorized') }}
                </div>

                <!-- Title -->
                <h3 class="text-lg font-bold text-gray-800 mb-3 line-clamp-2">
                    <a href="{{ route('shop.products.show', $product->slug) }}" class="hover:text-green-600 transition-colors">
                        {{ $product->localized_name }}
                    </a>
                </h3>

                <!-- Stock Status -->
                <div class="flex items-center gap-2 mb-4 py-3 border-y border-dashed border-gray-200">
                    <span class="w-3 h-3 rounded-full {{ $stock && $stock->available_quantity > 0 ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                    <span class="text-sm font-medium {{ $stock && $stock->available_quantity > 0 ? 'text-gray-600' : 'text-red-600' }}">
                        <strong class="text-lg">{{ number_format($stock->available_quantity ?? 0) }}</strong>
                        {{ $isArabic ? 'كجم متوفر' : 'KG Available' }}
                    </span>
                </div>

                <!-- Price Section -->
                @if(Auth::check() && $price)
                    <div class="mt-auto">
                        <div class="flex items-baseline gap-2 mb-4">
                            <span class="text-2xl font-extrabold text-green-700">{{ number_format($price->price, 2) }}</span>
                            <span class="text-green-600 font-medium">{{ $isArabic ? 'ر.س' : 'SAR' }}</span>
                        </div>

                        @if($stock && $stock->available_quantity > 0)
                            <!-- Add to Cart Form -->
                            <form action="{{ route('shop.cart.add') }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="{{ $product->min_order_quantity ?? 1 }}">
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-4 rounded-full flex items-center justify-center gap-2 shadow-lg shadow-green-600/30 hover:shadow-xl hover:shadow-green-600/40 transition-all duration-300 hover:-translate-y-1">
                                    <i class="fas fa-cart-plus"></i>
                                    {{ $isArabic ? 'أضف للسلة' : 'Add to Cart' }}
                                </button>
                            </form>
                        @else
                            <div class="w-full bg-red-100 text-red-600 font-bold py-3 px-4 rounded-full flex items-center justify-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $isArabic ? 'غير متوفر' : 'Out of Stock' }}
                            </div>
                        @endif

                        <!-- View Details Link -->
                        <a href="{{ route('shop.products.show', $product->slug) }}" 
                           class="block w-full text-center mt-3 py-2 text-green-600 font-medium hover:text-green-800 transition-colors">
                            <i class="fas fa-eye ml-1"></i>
                            {{ $isArabic ? 'عرض التفاصيل' : 'View Details' }}
                        </a>
                    </div>
                @elseif(Auth::check())
                    <!-- Price Not Available -->
                    <div class="mt-auto">
                        <div class="bg-gray-100 text-gray-500 font-bold py-3 px-4 rounded-full flex items-center justify-center gap-2 mb-3">
                            <i class="fas fa-ban"></i>
                            {{ $isArabic ? 'السعر غير متاح' : 'Price not available' }}
                        </div>
                        <a href="{{ route('shop.products.show', $product->slug) }}" 
                           class="block w-full text-center py-2 text-green-600 font-medium hover:text-green-800 transition-colors">
                            <i class="fas fa-eye ml-1"></i>
                            {{ $isArabic ? 'عرض التفاصيل' : 'View Details' }}
                        </a>
                    </div>
                @else
                    <!-- Login Required -->
                    <div class="mt-auto">
                        <div class="bg-blue-50 text-blue-600 font-bold py-3 px-4 rounded-full flex items-center justify-center gap-2 mb-3">
                            <i class="fas fa-lock"></i>
                            {{ $isArabic ? 'سجل دخول لعرض السعر' : 'Login to view price' }}
                        </div>
                        <a href="{{ route('login') }}" 
                           class="block w-full bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-3 px-4 rounded-full flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
                            <i class="fas fa-sign-in-alt"></i>
                            {{ $isArabic ? 'تسجيل الدخول' : 'Login' }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'links'))
    <div class="mt-12 flex justify-center">
        {{ $products->links() }}
    </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
        <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-box-open text-4xl text-green-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $isArabic ? 'لا توجد منتجات' : 'No Products Found' }}</h3>
        <p class="text-gray-500 mb-6">{{ $isArabic ? 'سيتم إضافة منتجات قريباً' : 'Products will be added soon' }}</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-full font-bold hover:bg-green-700 transition-colors">
            <i class="fas fa-home"></i>
            {{ $isArabic ? 'العودة للرئيسية' : 'Back to Home' }}
        </a>
    </div>
@endif

<!-- JavaScript for Add to Cart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.add-to-cart-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('button');
            const originalHTML = btn.innerHTML;
            const originalClass = btn.className;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            try {
                await new Promise(resolve => setTimeout(resolve, 800));
                
                btn.innerHTML = '<i class="fas fa-check"></i> {{ $isArabic ? "تمت الإضافة" : "Added" }}';
                btn.classList.remove('from-green-600', 'to-green-700', 'hover:from-green-700', 'hover:to-green-800');
                btn.classList.add('from-amber-500', 'to-amber-600');
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.className = originalClass;
                    btn.disabled = false;
                }, 2000);
                
            } catch (error) {
                btn.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                btn.classList.remove('from-green-600', 'to-green-700');
                btn.classList.add('bg-red-600');
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.className = originalClass;
                    btn.disabled = false;
                }, 2000);
            }
        });
    });
});
</script>
@endsection
