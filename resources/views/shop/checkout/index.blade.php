@extends('shop.layouts.shop-new')

@section('title', __('messages.checkout'))

@section('styles')
<style>
:root {
    --primary-color: #2E7D32;
    --secondary-color: #4CAF50;
    --accent-color: #81C784;
    --dark-green: #1B5E20;
}

.checkout-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.payment-method-card {
    cursor: pointer;
}

.payment-method-card input[type="radio"] {
    display: none;
}

.payment-card {
    border: 2px solid #dee2e6;
    border-radius: 12px;
    padding: 25px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.payment-method-card input[type="radio"]:checked + .payment-card {
    border-color: var(--primary-color);
    background-color: rgba(46, 125, 50, 0.05);
    box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
}

.payment-method-card .payment-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.order-summary-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    position: sticky;
    top: 20px;
}

.branch-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    background: linear-gradient(135deg, var(--primary-color), var(--dark-green));
    color: white;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    padding: 12px 24px;
    font-weight: 600;
    border-radius: 8px;
}

.btn-primary:hover {
    background-color: var(--dark-green);
    border-color: var(--dark-green);
}

.alert-warning {
    border-radius: 8px;
    border: none;
    background: linear-gradient(135deg, #fff3cd, #ffe69c);
}
</style>
@endsection

@section('content')
<div class="checkout-container">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('shop.products.index') }}">{{ __('messages.products') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop.cart.index') }}">{{ __('messages.cart') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('messages.checkout') }}</li>
                    </ol>
                </nav>
                <h2 class="fw-bold">{{ __('messages.checkout') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4 fw-bold">
                            <i class="fas fa-credit-card me-2 text-success"></i>
                            {{ __('messages.select_payment_method') }}
                        </h5>
                        
                        @if($gatewayInfo['is_sandbox'])
                            <div class="alert alert-warning mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>{{ __('messages.testing_mode') }}:</strong>
                                {{ __('messages.sandbox_mode_message') }}
                            </div>
                        @endif

                        <!-- Form with POST -->
                        <form action="{{ route('shop.checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            
                            <div class="row mb-4">
                                @foreach($paymentMethods as $key => $method)
                                    <div class="col-md-4 mb-3">
                                        <label class="payment-method-card">
                                            <input type="radio" name="payment_method" value="{{ $key }}" 
                                                {{ $loop->first ? 'checked' : '' }} required>
                                            <div class="payment-card">
                                                <i class="{{ $method['icon'] }}" style="font-size: 2.5rem; color: {{ $method['color'] }};"></i>
                                                <span class="mt-3 d-block fw-bold">
                                                    {{ app()->getLocale() === 'ar' ? $method['name_ar'] : $method['name'] }}
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @error('payment_method')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <!-- Order Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold">{{ __('messages.notes') }}</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                    placeholder="{{ __('messages.optional_notes_for_order') }}"></textarea>
                            </div>

<!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                                <i class="fas fa-lock me-2"></i>
                                {{ __('messages.place_order') }}
                            </button>
                        </form>
                        
                        <script>
                        document.getElementById('checkout-form').addEventListener('submit', function(e) {
                            var btn = document.getElementById('submitBtn');
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري المعالجة...';
                        });
                        </script>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="order-summary-card card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-shopping-bag me-2 text-success"></i>
                            {{ __('messages.order_summary') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($cart->items as $item)
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <div>
                                    <strong>{{ $item->product->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $item->quantity }} x {{ number_format($item->price, 2) }} {{ __('messages.sar') }}</small>
                                </div>
                                <div class="fw-bold">{{ number_format($item->quantity * $item->price, 2) }} {{ __('messages.sar') }}</div>
                            </div>
                        @endforeach
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('messages.subtotal') }}</span>
                            <span>{{ number_format($cart->subtotal, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('messages.tax') }} (15%)</span>
                            <span>{{ number_format($cart->tax, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">{{ __('messages.shipping') }}</span>
                            <span>{{ number_format($cart->shipping ?? 0, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <strong class="fs-5">{{ __('messages.total') }}</strong>
                            <strong class="fs-5 text-success">{{ number_format($cart->total, 2) }} {{ __('messages.sar') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Branch Info -->
                @if($cart->branch)
                <div class="branch-card card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="fas fa-building me-2"></i>
                            {{ __('messages.order_branch') }}
                        </h6>
                        <p class="mb-2 fw-bold">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $cart->branch->name }}
                        </p>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-city me-2"></i>
                            {{ $cart->branch->city }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Security Info -->
                <div class="text-center p-3 bg-light rounded">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1 text-success"></i>
                        {{ __('messages.your_payment_information_secured') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
