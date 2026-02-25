@extends('shop.layouts.shop-new')

@section('title', __('messages.shopping_cart'))

@section('styles')
<style>
:root {
    --primary-color: #2E7D32;
    --secondary-color: #4CAF50;
    --dark-green: #1B5E20;
}

.cart-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.cart-item {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}

.cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.cart-item img {
    border-radius: 8px;
    object-fit: cover;
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #aaa;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-controls button {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-controls input {
    width: 60px;
    text-align: center;
    border-radius: 8px;
}

.price-tag {
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--primary-color);
}

.summary-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    position: sticky;
    top: 20px;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--dark-green);
    border-color: var(--dark-green);
}

.btn-success {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
}

.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.empty-cart i {
    font-size: 4rem;
    color: #ddd;
}
</style>
@endsection

@section('content')
<div class="cart-container">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('shop.products.index') }}">{{ __('messages.products') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('messages.shopping_cart') }}</li>
                    </ol>
                </nav>
                <h2 class="fw-bold">
                    <i class="fas fa-shopping-cart me-2 text-success"></i>
                    {{ __('messages.shopping_cart') }}
                </h2>
            </div>
        </div>

        @if($summary['items_count'] > 0)
            <div class="row">
                <!-- Cart Items -->
                <div class="col-md-8">
                    @foreach($summary['items'] as $item)
                        <div class="cart-item" data-id="{{ $item['id'] }}">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <div class="product-image">
                                        <i class="fas fa-box"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1">{{ $item['name'] }}</h5>
                                    <p class="text-muted small mb-0">{{ __('messages.sku') }}: {{ $item['sku'] }}</p>
                                    @if($item['is_wholesale'])
                                        <span class="badge bg-success mt-2">{{ __('messages.wholesale_price_applied') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="quantity-controls">
                                        <button class="btn btn-outline-secondary quantity-minus" type="button">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="form-control quantity-input" 
                                               value="{{ $item['quantity'] }}" min="0" 
                                               data-item-id="{{ $item['id'] }}">
                                        <button class="btn btn-outline-secondary quantity-plus" type="button">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div>
                                        <span class="price-tag">{{ number_format($item['total'], 2) }}</span>
                                        <small class="text-muted d-block">{{ __('messages.sar') }}</small>
                                        @if($item['unit_price'] != $item['total']/$item['quantity'])
                                            <small class="text-muted">
                                                {{ number_format($item['unit_price'], 2) }} {{ __('messages.sar') }}/{{ __('messages.unit') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-sm btn-outline-danger remove-item" data-item-id="{{ $item['id'] }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="text-end mt-3">
                        <button class="btn btn-outline-danger" id="clearCart">
                            <i class="fas fa-trash-alt me-1"></i> {{ __('messages.clear_cart') }}
                        </button>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="col-md-4">
                    <div class="summary-card card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-clipboard-list me-2 text-success"></i>
                                {{ __('messages.order_summary') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <span class="text-muted">{{ __('messages.subtotal') }}</span>
                                <span class="fw-bold">{{ number_format($summary['subtotal'], 2) }} {{ __('messages.sar') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <span class="text-muted">{{ __('messages.tax') }} (15%)</span>
                                <span class="fw-bold">{{ number_format($summary['tax'], 2) }} {{ __('messages.sar') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">{{ __('messages.shipping') }}</span>
                                <span class="fw-bold">0.00 {{ __('messages.sar') }}</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">{{ __('messages.total') }}</span>
                                <span class="fw-bold fs-5 text-success">{{ number_format($summary['total'], 2) }} {{ __('messages.sar') }}</span>
                            </div>
                            
                            <a href="{{ route('shop.checkout.index') }}" class="btn btn-success w-100 py-2 mb-2">
                                <i class="fas fa-credit-card me-2"></i>
                                {{ __('messages.proceed_to_checkout') }}
                            </a>
                            
                            <a href="{{ route('shop.products.index') }}" class="btn btn-outline-primary w-100 py-2">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('messages.continue_shopping') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <i class="fas fa-shopping-cart mb-3"></i>
                <h4>{{ __('messages.cart_is_empty') }}</h4>
                <p class="text-muted">{{ __('messages.cart_empty_message') }}</p>
                <a href="{{ route('shop.products.index') }}" class="btn btn-success mt-3">
                    <i class="fas fa-store me-2"></i>
                    {{ __('messages.browse_products') }}
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // تحديث الكمية
    $('.quantity-input').on('change', function() {
        let itemId = $(this).data('item-id');
        let quantity = $(this).val();
        updateQuantity(itemId, quantity);
    });
    
    $('.quantity-minus').on('click', function() {
        let input = $(this).siblings('.quantity-input');
        let itemId = input.data('item-id');
        let currentVal = parseInt(input.val());
        if (currentVal > 0) {
            input.val(currentVal - 1).trigger('change');
        }
    });
    
    $('.quantity-plus').on('click', function() {
        let input = $(this).siblings('.quantity-input');
        let itemId = input.data('item-id');
        let currentVal = parseInt(input.val());
        input.val(currentVal + 1).trigger('change');
    });
    
    // حذف منتج
    $('.remove-item').on('click', function() {
        if (confirm('{{ __('messages.confirm_remove_item') }}')) {
            let itemId = $(this).data('item-id');
            updateQuantity(itemId, 0);
        }
    });
    
    // تفريغ السلة
    $('#clearCart').on('click', function() {
        if (confirm('{{ __('messages.confirm_clear_cart') }}')) {
            $.ajax({
                url: '{{ route("shop.cart.clear") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    }
                }
            });
        }
    });
    
    function updateQuantity(itemId, quantity) {
        $.ajax({
            url: '{{ url("/cart/update") }}/' + itemId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert('{{ __('messages.error_updating_cart') }}');
                }
            }
        });
    }
});
</script>
@endpush
@endsection
