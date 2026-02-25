@extends('shop.layouts.shop-new')

@section('title', $product->localized_name)

@section('styles')
<style>
.page-header {
    background: linear-gradient(135deg, rgba(27,94,32,0.92), rgba(46,125,50,0.88)), 
                url('https://images.unsplash.com/photo-1586201375761-83865001e31c?w=1920');
    background-size: cover;
    background-position: center;
    padding: 180px 0 80px;
    margin-top: 70px;
}
.page-header h1 { font-size: 3rem; font-weight: 800; color: white; margin-bottom: 10px; }
.page-header p { font-size: 1.2rem; color: rgba(255,255,255,0.9); }
.breadcrumb-item a { color: rgba(255,255,255,0.7) !important; text-decoration: none; }
.breadcrumb-item.active { color: white !important; }
.product-card { border-radius: 25px; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.1); }
.product-image { background: linear-gradient(145deg, #f8fafc, #e2e8f0); padding: 60px; text-align: center; }
.product-image i { font-size: 150px; color: #94a3b8; }
.product-details { padding: 40px; background: white; }
.price-card { background: linear-gradient(135deg, #1B5E20, #2E7D32); border-radius: 15px; padding: 25px; color: white; }
.price-amount { font-size: 2.5rem; font-weight: 800; }
.stock-badge { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 10px; font-weight: 600; }
.stock-available { background: #dcfce7; color: #166534; }
.stock-low { background: #fef3c7; color: #92400e; }
.qty-selector { display: flex; align-items: center; background: #f1f5f9; border-radius: 10px; }
.qty-btn { width: 50px; height: 50px; border: none; background: #1B5E20; color: white; font-size: 1.5rem; cursor: pointer; }
.qty-input { flex: 1; border: none; text-align: center; font-weight: 700; font-size: 1.2rem; background: transparent; }
.btn-add-cart { width: 100%; background: linear-gradient(135deg, #1B5E20, #2E7D32); color: white; border: none; border-radius: 12px; padding: 18px; font-weight: 700; font-size: 1.1rem; }
.btn-add-cart:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(27, 94, 32, 0.3); }
.login-prompt { background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 15px; padding: 30px; text-align: center; color: white; }
.wholesale-badge { background: linear-gradient(135deg, #F59E0B, #D97706); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; }
.specs-table td { padding: 12px 0; border-bottom: 1px solid #eee; }
.specs-table th { color: #666; width: 150px; font-weight: 600; }
.related-card { border-radius: 15px; overflow: hidden; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
.related-card:hover { transform: translateY(-8px); }
.related-image { height: 150px; background: linear-gradient(145deg, #f8fafc, #e2e8f0); display: flex; align-items: center; justify-content: center; }
.related-image i { font-size: 50px; color: #94a3b8; }
@media (max-width: 768px) {
    .page-header h1 { font-size: 2rem; }
    .product-details { padding: 20px; }
}
</style>
@endsection

@section('content')
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.products.index') }}">{{ app()->getLocale() == 'ar' ? 'المنتجات' : 'Products' }}</a></li>
                <li class="breadcrumb-item active">{{ $product->localized_name }}</li>
            </ol>
        </nav>
        <h1>{{ $product->localized_name }}</h1>
        <p>{{ $product->category?->localized_name ?? (app()->getLocale() == 'ar' ? 'أرز عالي الجودة' : 'Premium Rice') }}</p>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="product-card">
                <div class="product-image">
                    <i class="fas fa-sack-grain"></i>
                </div>
                <div class="p-3 bg-white d-flex gap-2 flex-wrap">
                    @if($product->is_featured)
                    <span class="wholesale-badge"><i class="fas fa-star"></i> {{ app()->getLocale() == 'ar' ? 'مميز' : 'Featured' }}</span>
                    @endif
                    @if($product->created_at->diffInDays(now()) <= 7)
                    <span class="badge bg-success">{{ app()->getLocale() == 'ar' ? 'جديد' : 'NEW' }}</span>
                    @endif
                    <span class="badge bg-light text-dark"><i class="fas fa-barcode"></i> {{ $product->sku }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="product-details h-100">
                @auth
                    @if($price)
                        <div class="price-card mb-4">
                            <div class="text-white-70 small mb-2">{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="price-amount">{{ number_format($price->final_price, 2) }}</span>
                                <span>{{ app()->getLocale() == 'ar' ? 'ريال' : 'SAR' }}</span>
                                @if($price->discount_percentage > 0)
                                <span class="badge bg-danger">{{ app()->getLocale() == 'ar' ? 'خصم' : 'Off' }} {{ $price->discount_percentage }}%</span>
                                @endif
                            </div>
                            @if($price->wholesale_price)
                            <div class="mt-3 pt-3 border-top border-white">
                                <div class="text-warning fw-bold mb-2">سعر الجملة</div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-white-70">السعر</span>
                                    <span class="fw-bold">{{ number_format($price->wholesale_price, 2) }} ريال</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($stock && $stock->available_quantity > 0)
                        <div class="mb-4">
                            <span class="stock-badge {{ $stock->available_quantity > 10 ? 'stock-available' : 'stock-low' }}">
                                <i class="fas fa-check-circle"></i>
                                متوفر: {{ number_format($stock->available_quantity) }} كجم
                            </span>
                        </div>

                        <form action="{{ route('shop.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <label class="form-label fw-bold">الكمية</label>
                            <div class="qty-selector mb-3" style="max-width: 280px;">
                                <button type="button" class="qty-btn" onclick="var i=document.getElementById('q');i.value=Math.max({{$product->min_order_quantity}},parseInt(i.value)-{{$product->min_order_quantity}})">-</button>
                                <input type="number" name="quantity" id="q" class="qty-input" value="{{ $product->min_order_quantity }}" min="{{ $product->min_order_quantity }}">
                                <button type="button" class="qty-btn" onclick="var i=document.getElementById('q');i.value=Math.min({{$stock->available_quantity}},parseInt(i.value)+{{$product->min_order_quantity}})">+</button>
                            </div>
                            <button type="submit" class="btn-add-cart">
                                <i class="fas fa-cart-plus me-2"></i>{{ app()->getLocale() == 'ar' ? 'أضف للسلة' : 'Add to Cart' }}
                            </button>
                        </form>
                        @else
                        <div class="alert alert-danger">غير متوفر</div>
                        @endif
                    @else
                    <div class="alert alert-warning">السعر غير متوفر</div>
                    @endif
                @else
                    <div class="login-prompt mb-4">
                        <i class="fas fa-lock fa-3x mb-3"></i>
                        <h5 class="fw-bold">سجل دخولك للمتابعة</h5>
                        <a href="{{ route('login') }}" class="btn btn-light">تسجيل الدخول</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">الوصف</h4>
                    <p class="text-muted">{{ $product->localized_description ?? 'لا يوجد وصف' }}</p>
                    <h5 class="fw-bold mt-4 mb-3">المواصفات</h5>
                    <table class="table specs-table">
                        <tr><th>الوحدة</th><td class="fw-bold">{{ $product->unit }}</td></tr>
                        <tr><th>الوزن</th><td class="fw-bold">{{ $product->unit_weight }} كجم</td></tr>
                        <tr><th>الحد الأدنى</th><td class="fw-bold">{{ $product->min_order_quantity }} كجم</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->isNotEmpty())
    <div class="mt-5">
        <h4 class="mb-4">منتجات ذات صلة</h4>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 col-6 mb-3">
                <a href="{{ route('shop.products.show', $related->slug) }}" class="text-decoration-none">
                    <div class="related-card">
                        <div class="related-image"><i class="fas fa-sack-grain"></i></div>
                        <div class="p-3">
                            <h6 class="fw-bold text-dark">{{ $related->localized_name }}</h6>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
