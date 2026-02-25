@extends('layouts.app')

@section('title', __('Payment Successful'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-success">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h2 class="mb-3">{{ __('Thank You!') }}</h2>
                    <p class="lead">{{ __('Your order has been placed successfully.') }}</p>
                    
                    <div class="alert alert-success">
                        <strong>{{ __('Order Number') }}:</strong> {{ $order->order_number }}
                    </div>

                    <hr>

                    <div class="row text-start">
                        <div class="col-md-6">
                            <h5>{{ __('Order Details') }}</h5>
                            <p>
                                <strong>{{ __('Branch') }}:</strong> {{ $order->branch->name }}<br>
                                <strong>{{ __('Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ __('Payment') }}</h5>
                            <p>
                                <strong>{{ __('Total') }}:</strong> {{ number_format($order->total, 2) }} SAR<br>
                                <strong>{{ __('Status') }}:</strong> 
                                <span class="badge bg-success">{{ __('Paid') }}</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('shop.orders.show', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                            {{ __('View Order') }}
                        </a>
                        <a href="{{ route('shop.orders.invoice', $order->id) }}" class="btn btn-secondary">
                            <i class="fas fa-file-invoice"></i>
                            {{ __('Print Invoice') }}
                        </a>
                        <a href="{{ route('shop.products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag"></i>
                            {{ __('Continue Shopping') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('Order Items') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Product') }}</th>
                                    <th class="text-center">{{ __('Quantity') }}</th>
                                    <th class="text-end">{{ __('Price') }}</th>
                                    <th class="text-end">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                            @if($item->product_name_ar)
                                                <br>
                                                <small class="text-muted">{{ $item->product_name_ar }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->price, 2) }}</td>
                                        <td class="text-end">{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('Subtotal') }}</strong></td>
                                    <td class="text-end">{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">{{ __('Tax') }}</td>
                                    <td class="text-end">{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">{{ __('Shipping') }}</td>
                                    <td class="text-end">{{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('Total') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
