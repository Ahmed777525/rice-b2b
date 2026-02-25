@extends('shop.layouts.shop-new')

@section('title', __('messages.my_orders'))

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

    .orders-header {
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
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .order-card .card-header {
        background: transparent;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
    }

    .order-card .card-body {
        padding: 1.5rem;
    }

    .order-number {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
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

    .order-info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .order-info-item:last-child {
        border-bottom: none;
    }

    .order-info-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .order-info-content {
        flex: 1;
    }

    .order-info-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .order-info-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    .total-amount {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    .btn-view-order {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-view-order:hover {
        background: var(--primary-dark);
        color: white;
        transform: translateX(4px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    .pagination {
        margin-top: 2rem;
    }

    .pagination .page-link {
        color: var(--primary);
        border-color: #e2e8f0;
        padding: 0.75rem 1rem;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
    }

    .pagination .page-link:hover {
        background: var(--primary-soft);
        border-color: var(--primary);
    }

    @media (max-width: 768px) {
        .order-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="orders-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="text-white mb-1">
                    <i class="fas fa-clipboard-list me-2"></i>
                    {{ __('messages.my_orders') }}
                </h1>
                <p class="text-white-50 mb-0">{{ __('messages.track_your_orders') }}</p>
            </div>
            <a href="{{ route('shop.products.index') }}" class="btn btn-light">
                <i class="fas fa-shopping-bag me-2"></i>
                {{ __('messages.browse_products') }}
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">
    @if($orders->isEmpty())
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h3>{{ __('messages.no_orders') }}</h3>
            <p>{{ __('messages.no_orders_message') }}</p>
            <a href="{{ route('shop.products.index') }}" class="btn-view-order">
                <i class="fas fa-arrow-right"></i>
                {{ __('messages.start_shopping') }}
            </a>
        </div>
    @else
        <!-- Orders Grid -->
        <div class="row">
            @foreach($orders as $order)
                <div class="col-lg-6 mb-4">
                    <div class="order-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="order-number">{{ $order->order_number }}</span>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ __("messages.order_status_{$order->status}") }}
                            </span>
                        </div>
                        <div class="card-body">
                            <!-- Order Info -->
                            <div class="order-info-item">
                                <div class="order-info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="order-info-content">
                                    <div class="order-info-label">{{ __('messages.order_date') }}</div>
                                    <div class="order-info-value">{{ $order->created_at->format('Y-m-d') }}</div>
                                </div>
                            </div>
                            
                            <div class="order-info-item">
                                <div class="order-info-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="order-info-content">
                                    <div class="order-info-label">{{ __('messages.items') }}</div>
                                    <div class="order-info-value">{{ $order->items->count() }} {{ __('messages.product') }}</div>
                                </div>
                            </div>
                            
                            <div class="order-info-item">
                                <div class="order-info-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="order-info-content">
                                    <div class="order-info-label">{{ __('messages.payment_status') }}</div>
                                    <div class="order-info-value">
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                            {{ __("messages.payment_{$order->payment_status}") }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="order-info-item">
                                <div class="order-info-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="order-info-content">
                                    <div class="order-info-label">{{ __('messages.total') }}</div>
                                    <div class="total-amount">{{ number_format($order->total, 2) }}</div>
                                </div>
                            </div>
                            
                            <!-- View Details Button -->
                            <div class="text-center mt-4">
                                <a href="{{ route('shop.orders.show', $order->id) }}" class="btn-view-order">
                                    <i class="fas fa-eye"></i>
                                    {{ __('messages.view_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
