<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.invoice') }} - {{ $order->order_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2E7D32;
        }
        body {
            font-family: 'Cairo', 'Segoe UI', sans-serif;
            background: #f5f5f5;
        }
        .invoice-wrapper {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .invoice-header {
            border-bottom: 3px solid var(--primary);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        .invoice-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }
        .info-label {
            font-size: 0.85rem;
            color: #666;
        }
        .info-value {
            font-weight: 600;
            color: #333;
        }
        .table th {
            background: var(--primary);
            color: white;
            padding: 1rem;
        }
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }
        .total-row {
            background: var(--primary);
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
        }
        @media print {
            body { background: white; }
            .invoice-wrapper { box-shadow: none; margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-wrapper">
        <!-- Header -->
        <div class="invoice-header d-flex justify-content-between align-items-start">
            <div>
                <div class="company-name">{{ __('messages.company_name') }}</div>
                <p class="mb-0 text-muted">
                    {{ app()->getLocale() == 'ar' ? 'شركة الأرز للأعمال' : 'Rice Business Company' }}
                </p>
            </div>
            <div class="text-end">
                <div class="invoice-title">{{ __('messages.invoice') }}</div>
                <div class="info-value">{{ $order->order_number }}</div>
            </div>
        </div>

        <!-- Info Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-2">{{ __('messages.customer_information') }}</h6>
                <div class="info-value">{{ $order->user_name }}</div>
                <div class="info-label">{{ $order->user_email }}</div>
                <div class="info-label">{{ $order->user_phone }}</div>
                @if($order->company_name)
                    <div class="info-label">{{ $order->company_name }}</div>
                @endif
            </div>
            <div class="col-md-6 text-md-end">
                <h6 class="text-muted mb-2">{{ __('messages.order_information') }}</h6>
                <div class="info-label">{{ __('messages.order_date') }}: <span class="info-value">{{ $order->created_at->format('Y-m-d') }}</span></div>
                <div class="info-label">{{ __('messages.payment_method') }}: <span class="info-value">{{ __("messages.payment_method_{$order->payment_method}") }}</span></div>
                <div class="info-label">{{ __('messages.payment_status') }}: 
                    <span class="status-badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                        {{ __("messages.payment_{$order->payment_status}") }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="table table-bordered">
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
                            @if($item->product_sku)
                                <br><small class="text-muted">{{ __('messages.sku') }}: {{ $item->product_sku }}</small>
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
                    <td colspan="3" class="text-end">{{ __('messages.subtotal') }}</td>
                    <td class="text-end">{{ number_format($order->subtotal, 2) }} {{ __('messages.sar') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">{{ __('messages.tax') }} (15%)</td>
                    <td class="text-end">{{ number_format($order->tax, 2) }} {{ __('messages.sar') }}</td>
                </tr>
                @if($order->shipping_cost > 0)
                <tr>
                    <td colspan="3" class="text-end">{{ __('messages.shipping') }}</td>
                    <td class="text-end">{{ number_format($order->shipping_cost, 2) }} {{ __('messages.sar') }}</td>
                </tr>
                @endif
                @if($order->discount > 0)
                <tr>
                    <td colspan="3" class="text-end">{{ __('messages.discount') }}</td>
                    <td class="text-end text-success">-{{ number_format($order->discount, 2) }} {{ __('messages.sar') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="3" class="text-end">{{ __('messages.total') }}</td>
                    <td class="text-end">{{ number_format($order->total, 2) }} {{ __('messages.sar') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="mt-4 pt-4 border-top">
            <p class="text-muted small text-center">
                {{ app()->getLocale() == 'ar' ? 'شكراً لتعاملكم معنا' : 'Thank you for your business' }}
            </p>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>
                {{ __('messages.print_invoice') }}
            </button>
            <a href="{{ route('shop.orders.index') }}" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-right me-2"></i>
                {{ __('messages.back_to_orders') }}
            </a>
        </div>
    </div>
</body>
</html>
