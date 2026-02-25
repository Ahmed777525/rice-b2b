@extends('shop.layouts.shop')

@section('title', __('messages.order_details') . ' - ' . $order->order_number)

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.orders.index') }}">{{ __('messages.my_orders') }}</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('messages.order_details') }}</h5>
                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} fs-6">
                            {{ __("messages.order_status_{$order->status}") }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>{{ __('messages.order_information') }}</h6>
                            <p class="mb-1"><strong>{{ __('messages.order_number') }}:</strong> {{ $order->order_number }}</p>
                            <p class="mb-1"><strong>{{ __('messages.order_date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <p class="mb-1"><strong>{{ __('messages.payment_method') }}:</strong> {{ __("messages.payment_method_{$order->payment_method}") }}</p>
                            <p class="mb-1"><strong>{{ __('messages.payment_status') }}:</strong> 
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                    {{ __("messages.payment_{$order->payment_status}") }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>{{ __('messages.shipping_address') }}</h6>
                            <p class="mb-1">{{ $order->shipping_address }}</p>
                            <p class="mb-1">{{ $order->shipping_city }}</p>
                            <p class="mb-1">{{ __('messages.phone') }}: {{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">{{ __('messages.order_items') }}</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.product') }}</th>
                                    <th class="text-center">{{ __('messages.quantity') }}</th>
                                    <th class="text-end">{{ __('messages.unit_price') }}</th>
                                    <th class="text-end">{{ __('messages.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product_name }}
                                            @if($item->is_wholesale)
                                                <br><small class="text-success">{{ __('messages.wholesale_price_applied') }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->unit_price, 2) }} {{ __('messages.sar') }}</td>
                                        <td class="text-end">{{ number_format($item->total, 2) }} {{ __('messages.sar') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('messages.subtotal') }}:</strong></td>
                                    <td class="text-end">{{ number_format($order->subtotal, 2) }} {{ __('messages.sar') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('messages.tax') }}:</strong></td>
                                    <td class="text-end">{{ number_format($order->tax, 2) }} {{ __('messages.sar') }}</td>
                                </tr>
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('messages.shipping') }}:</strong></td>
                                    <td class="text-end">{{ number_format($order->shipping_cost, 2) }} {{ __('messages.sar') }}</td>
                                </tr>
                                @endif
                                @if($order->discount > 0)
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('messages.discount') }}:</strong></td>
                                    <td class="text-end">-{{ number_format($order->discount, 2) }} {{ __('messages.sar') }}</td>
                                </tr>
                                @endif
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end"><strong>{{ __('messages.total') }}:</strong></td>
                                    <td class="text-end">{{ number_format($order->total, 2) }} {{ __('messages.sar') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    @if($order->notes)
                        <div class="mt-3">
                            <h6>{{ __('messages.order_notes') }}</h6>
                            <p class="text-muted">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('messages.order_actions') }}</h6>
                </div>
                <div class="card-body">
                    @if($order->canBeCancelled())
                        <form action="{{ route('shop.orders.cancel', $order->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="reason" class="form-label">{{ __('messages.cancellation_reason') }}</label>
                                <textarea class="form-control" id="reason" name="reason" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('{{ __('messages.confirm_cancel_order') }}')">
                                {{ __('messages.cancel_order') }}
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('shop.orders.invoice', $order->id) }}" class="btn btn-outline-primary w-100 mt-2">
                        <i class="fas fa-download"></i> {{ __('messages.download_invoice') }}
                    </a>
                    
                    <a href="{{ route('shop.products.index') }}" class="btn btn-outline-success w-100 mt-2">
                        {{ __('messages.order_again') }}
                    </a>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <h6>{{ __('messages.timeline') }}</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            {{ __('messages.order_placed') }}: {{ $order->created_at->format('Y-m-d H:i') }}
                        </li>
                        @if($order->approved_at)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            {{ __('messages.order_approved') }}: {{ $order->approved_at->format('Y-m-d H:i') }}
                        </li>
                        @endif
                        @if($order->shipped_at)
                        <li class="mb-2">
                            <i class="fas fa-truck text-info"></i>
                            {{ __('messages.order_shipped') }}: {{ $order->shipped_at->format('Y-m-d H:i') }}
                        </li>
                        @endif
                        @if($order->completed_at)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            {{ __('messages.order_completed') }}: {{ $order->completed_at->format('Y-m-d H:i') }}
                        </li>
                        @endif
                        @if($order->cancelled_at)
                        <li class="mb-2">
                            <i class="fas fa-times-circle text-danger"></i>
                            {{ __('messages.order_cancelled') }}: {{ $order->cancelled_at->format('Y-m-d H:i') }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection