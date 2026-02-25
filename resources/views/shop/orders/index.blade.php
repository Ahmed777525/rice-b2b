@extends('shop.layouts.shop')

@section('title', __('messages.my_orders'))

@section('content')
<div class="container my-5">
    <h1 class="mb-4">{{ __('messages.my_orders') }}</h1>
    
    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-box-open fa-3x mb-3"></i>
            <h4>{{ __('messages.no_orders') }}</h4>
            <p>{{ __('messages.no_orders_message') }}</p>
            <a href="{{ route('shop.products.index') }}" class="btn btn-primary">
                {{ __('messages.browse_products') }}
            </a>
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ __('messages.order_number') }}: {{ $order->order_number }}</strong>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ __("messages.order_status_{$order->status}") }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">{{ __('messages.order_date') }}</small>
                                    <p>{{ $order->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">{{ __('messages.total') }}</small>
                                    <p class="price-tag">{{ number_format($order->total, 2) }} {{ __('messages.sar') }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted">{{ __('messages.items') }}: {{ $order->items->count() }}</small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ __('messages.payment_status') }}: 
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                        {{ __("messages.payment_{$order->payment_status}") }}
                                    </span>
                                </small>
                                
                                <a href="{{ route('shop.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                    {{ __('messages.view_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection