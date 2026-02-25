@extends('shop.layouts.shop-new')

@section('title', __('messages.order_details') . ' - ' . $order->order_number)

@section('styles')
<style>
    :root {
        --primary: #2E7D32;
        --primary-dark: #1B5E20;
        --primary-light: #4CAF50;
        --primary-soft: #E8F5E9;
        
        --bg-main: #f8fafc;
        --bg-card: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
        
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-sm: 8px;
    }

    body {
        background: var(--bg-main);
        font-family: 'Cairo', 'Vazir', 'Iran Sans', sans-serif;
    }

    .order-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    }

    .order-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        border: none;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .order-card .card-header {
        background: white;
        border-bottom: 2px solid var(--primary-soft);
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    .order-card .card-body {
        padding: 1.5rem;
    }

    .order-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-pending {
        background: #FEF3C7;
        color: #92400E;
    }

    .status-approved {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .status-processing {
        background: #E0E7FF;
        color: #3730A3;
    }

    .status-shipped {
        background: #CFFAFE;
        color: #155E75;
    }

    .status-completed {
        background: #D1FAE5;
        color: #065F46;
    }

    .status-cancelled, .status-rejected {
        background: #FEE2E2;
        color: #991B1B;
    }

    .info-section {
        background: var(--primary-soft);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-section h6 {
        color: var(--primary-dark);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-secondary);
    }

    .info-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table th {
        background: var(--primary-soft);
        color: var(--primary-dark);
        padding: 1rem;
        text-align: start;
        font-weight: 600;
    }

    .items-table td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .items-table tr:last-child td {
        border-bottom: none;
    }

    .wholesale-badge {
        background: var(--primary);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
    }

    .total-section {
        background: var(--primary-soft);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }

    .total-row.grand-total {
        border-top: 2px solid var(--primary);
        margin-top: 0.5rem;
        padding-top: 1rem;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
    }

    .btn-cancel {
        background: #dc2626;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-cancel:hover {
        background: #b91c1c;
    }

    .btn-action {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-action:hover {
        background: var(--primary-dark);
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-outline:hover {
        background: var(--primary-soft);
        color: var(--primary);
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -2rem;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--primary-light);
        border: 3px solid white;
        box-shadow: 0 0 0 2px var(--primary-soft);
    }

    .timeline-dot.active {
        background: var(--primary);
    }

    .timeline-content {
        padding-left: 0.5rem;
    }

    .timeline-date {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: white;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="order-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.orders.index') }}">{{ __('messages.my_orders') }}</a></li>
                <li class="breadcrumb-item active">{{ $order->order_number }}</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <h1 class="text-white mb-1">{{ $order->order_number }}</h1>
                <p class="text-white-50 mb-0">{{ __('messages.order_details') }}</p>
            </div>
            <span class="status-badge status-{{ $order->status }}">
                {{ __("messages.order_status_{$order->status}") }}
            </span>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Order Items -->
            <div class="order-card mb-4">
                <div class="card-header">
                    <i class="fas fa-boxes me-2"></i>
                    {{ __('messages.order_items') }}
                </div>
                <div class="card-body p-0">
                    <table class="items-table">
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
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->is_wholesale)
                                            <br>
                                            <span class="wholesale-badge">{{ __('messages.wholesale') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->unit_price, 2) }} {{ __('messages.sar') }}</td>
                                    <td class="text-end"><strong>{{ number_format($item->total, 2) }}</strong> {{ __('messages.sar') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Totals -->
                    <div class="total-section">
                        <div class="total-row">
                            <span>{{ __('messages.subtotal') }}</span>
                            <span>{{ number_format($order->subtotal, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        <div class="total-row">
                            <span>{{ __('messages.tax') }} (15%)</span>
                            <span>{{ number_format($order->tax, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        @if($order->shipping_cost > 0)
                        <div class="total-row">
                            <span>{{ __('messages.shipping') }}</span>
                            <span>{{ number_format($order->shipping_cost, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        @endif
                        @if($order->discount > 0)
                        <div class="total-row">
                            <span>{{ __('messages.discount') }}</span>
                            <span class="text-success">-{{ number_format($order->discount, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                        @endif
                        <div class="total-row grand-total">
                            <span>{{ __('messages.total') }}</span>
                            <span>{{ number_format($order->total, 2) }} {{ __('messages.sar') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notes -->
            @if($order->notes)
            <div class="order-card">
                <div class="card-header">
                    <i class="fas fa-sticky-note me-2"></i>
                    {{ __('messages.order_notes') }}
                </div>
                <div class="card-body">
                    <p class="mb-0 text-muted">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- Order Info -->
            <div class="order-card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('messages.order_information') }}
                </div>
                <div class="card-body">
                    <div class="info-section">
                        <h6><i class="fas fa-calendar me-2"></i>{{ __('messages.order_date') }}</h6>
                        <div class="info-item">
                            <span class="info-value">{{ $order->created_at->format('Y-m-d') }}</span>
                            <span class="info-value">{{ $order->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h6><i class="fas fa-credit-card me-2"></i>{{ __('messages.payment') }}</h6>
                        <div class="info-item">
                            <span class="info-label">{{ __('messages.payment_method') }}</span>
                            <span class="info-value">{{ __("messages.payment_method_{$order->payment_method}") }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">{{ __('messages.payment_status') }}</span>
                            <span class="info-value">
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                    {{ __("messages.payment_{$order->payment_status}") }}
                                </span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h6><i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.shipping_address') }}</h6>
                        <div class="info-item">
                            <span class="info-value">{{ $order->shipping_address }}</span>
                        </div>
                        @if($order->shipping_city)
                        <div class="info-item">
                            <span class="info-label">{{ __('messages.city') }}</span>
                            <span class="info-value">{{ $order->shipping_city }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <span class="info-label">{{ __('messages.phone') }}</span>
                            <span class="info-value">{{ $order->shipping_phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="order-card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>
                    {{ __('messages.timeline') }}
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot active"></div>
                            <div class="timeline-content">
                                <strong>{{ __('messages.order_placed') }}</strong>
                                <div class="timeline-date">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                        
                        @if($order->approved_at)
                        <div class="timeline-item">
                            <div class="timeline-dot active"></div>
                            <div class="timeline-content">
                                <strong>{{ __('messages.order_approved') }}</strong>
                                <div class="timeline-date">{{ $order->approved_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($order->shipped_at)
                        <div class="timeline-item">
                            <div class="timeline-dot active"></div>
                            <div class="timeline-content">
                                <strong>{{ __('messages.order_shipped') }}</strong>
                                <div class="timeline-date">{{ $order->shipped_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($order->completed_at)
                        <div class="timeline-item">
                            <div class="timeline-dot active"></div>
                            <div class="timeline-content">
                                <strong>{{ __('messages.order_completed') }}</strong>
                                <div class="timeline-date">{{ $order->completed_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($order->cancelled_at)
                        <div class="timeline-item">
                            <div class="timeline-dot" style="background: #dc2626;"></div>
                            <div class="timeline-content">
                                <strong>{{ __('messages.order_cancelled') }}</strong>
                                <div class="timeline-date">{{ $order->cancelled_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="order-card">
                <div class="card-header">
                    <i class="fas fa-cogs me-2"></i>
                    {{ __('messages.order_actions') }}
                </div>
                <div class="card-body">
                    @if($order->canBeCancelled())
                        <form action="{{ route('shop.orders.cancel', $order->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="reason" class="form-label">{{ __('messages.cancellation_reason') }}</label>
                                <textarea class="form-control" id="reason" name="reason" rows="2" required></textarea>
                            </div>
                            <button type="submit" class="btn-cancel" 
                                    onclick="return confirm('{{ __('messages.confirm_cancel_order') }}')">
                                <i class="fas fa-times me-2"></i>
                                {{ __('messages.cancel_order') }}
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('shop.orders.invoice', $order->id) }}" class="btn-action w-100 mb-2">
                        <i class="fas fa-download"></i>
                        {{ __('messages.download_invoice') }}
                    </a>
                    
                    <a href="{{ route('shop.products.index') }}" class="btn-outline w-100">
                        <i class="fas fa-shopping-bag"></i>
                        {{ __('messages.order_again') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
