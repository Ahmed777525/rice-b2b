<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الطلب - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f5f6fa; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%); color: white; }
        .sidebar .logo { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .logo i { font-size: 40px; color: #e94560; }
        .sidebar .logo h4 { margin-top: 10px; font-weight: 700; }
        .sidebar-menu { padding: 15px; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 15px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: all 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-menu a i { width: 25px; margin-left: 10px; }
        .content-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .order-badge { padding: 8px 15px; border-radius: 20px; font-size: 0.85rem; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-approved { background: #dbeafe; color: #2563eb; }
        .badge-processing { background: #e0e7ff; color: #4f46e5; }
        .badge-shipped { background: #f3e8ff; color: #9333ea; }
        .badge-completed { background: #d1fae5; color: #059669; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; }
        .info-card { border: none; border-radius: 15px; }
        .info-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .timeline { position: relative; padding-left: 30px; }
        .timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: #e5e7eb; }
        .timeline-item { position: relative; padding-bottom: 20px; }
        .timeline-item::before { content: ''; position: absolute; left: -26px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: #e5e7eb; border: 2px solid #fff; }
        .timeline-item.active::before { background: #10b981; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="logo">
                    <i class="fas fa-sack-grain"></i>
                    <h4>أرز性质的</h4>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i><span>لوحة التحكم</span></a>
                    <a href="{{ route('admin.orders.index') }}" class="active"><i class="fas fa-shopping-cart"></i><span>الطلبات</span></a>
                    <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i><span>المنتجات</span></a>
                    <a href="{{ route('admin.stocks.index') }}"><i class="fas fa-warehouse"></i><span>المخزون</span></a>
                    <a href="{{ route('admin.branches.index') }}"><i class="fas fa-store"></i><span>الفروع</span></a>
                    <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>المستخدمون</span></a>
                    <a href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar"></i><span>التقارير</span></a>
                    <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i><span>الإعدادات</span></a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2><i class="fas fa-shopping-bag me-2"></i>طلب #{{ $order->order_number }}</h2>
                        <p class="text-muted mb-0">تاريخ الطلب: {{ $order->created_at->format('Y/m/d - H:i') }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-1"></i>رجوع
                        </a>
                        @if($order->status == 'pending')
                            <form method="POST" action="{{ route('admin.orders.approve', $order->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-1"></i>موافقة
                                </button>
                            </form>
                        @endif
                        @if($order->status != 'completed' && $order->status != 'cancelled')
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-exchange-alt me-1"></i>تغيير الحالة
                                </button>
                                <ul class="dropdown-menu">
                                    @if($order->status == 'pending')
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#statusModal" data-status="approved">
                                            <i class="fas fa-check me-2"></i>موافقة
                                        </a></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            <i class="fas fa-times me-2"></i>رفض
                                        </a></li>
                                    @endif
                                    @if($order->status == 'approved')
                                        <li>
                                            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-cog me-2"></i>بدء التجهيز
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    @if($order->status == 'processing')
                                        <li>
                                            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-truck me-2"></i>شحن الطلب
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    @if($order->status == 'shipped')
                                        <li>
                                            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-check-circle me-2"></i>تسليم كامل
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="content-card card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4"><i class="fas fa-route me-2"></i>حالة الطلب</h5>
                        <div class="timeline">
                            <div class="timeline-item {{ in_array($order->status, ['pending', 'approved', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
                                <strong>طلب جديد</strong>
                                <br><small class="text-muted">{{ $order->created_at->format('Y/m/d - H:i') }}</small>
                            </div>
                            <div class="timeline-item {{ in_array($order->status, ['approved', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
                                <strong>تم الموافقة</strong>
                                @if($order->approved_at)
                                    <br><small class="text-muted">{{ $order->approved_at->format('Y/m/d - H:i') }}</small>
                                @endif
                            </div>
                            <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'active' : '' }}">
                                <strong>قيد التجهيز</strong>
                                @if($order->processing_at)
                                    <br><small class="text-muted">{{ $order->processing_at->format('Y/m/d - H:i') }}</small>
                                @endif
                            </div>
                            <div class="timeline-item {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }}">
                                <strong>تم الشحن</strong>
                                @if($order->shipped_at)
                                    <br><small class="text-muted">{{ $order->shipped_at->format('Y/m/d - H:i') }}</small>
                                @endif
                            </div>
                            <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                                <strong>مكتمل</strong>
                                @if($order->completed_at)
                                    <br><small class="text-muted">{{ $order->completed_at->format('Y/m/d - H:i') }}</small>
                                @endif
                            </div>
                            @if($order->status == 'cancelled')
                            <div class="timeline-item active text-danger">
                                <strong>ملغي</strong>
                                @if($order->cancelled_at)
                                    <br><small class="text-muted">{{ $order->cancelled_at->format('Y/m/d - H:i') }}</small>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Left Column - Info -->
                    <div class="col-md-4">
                        <!-- Customer Info -->
                        <div class="content-card card mb-4">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>معلومات العميل</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-primary text-white me-3" style="width: 50px; height: 50px;">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $order->user->name }}</strong>
                                        <br><small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                                <hr>
                                <p class="mb-2"><i class="fas fa-phone me-2 text-muted"></i>{{ $order->user->phone ?? '-' }}</p>
                                <p class="mb-2"><i class="fas fa-building me-2 text-muted"></i>{{ $order->user->company_name ?? '-' }}</p>
                                <p class="mb-0"><i class="fas fa-file-alt me-2 text-muted"></i>{{ $order->user->commercial_record ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Order Info -->
                        <div class="content-card card mb-4">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات الطلب</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="text-muted small">الفرع</label>
                                    <p class="mb-0 fw-bold"><i class="fas fa-store me-2"></i>{{ $order->branch->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">حالة الدفع</label>
                                    <p class="mb-0">
                                        @if($order->payment_status == 'paid')
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>مدفوع</span>
                                        @else
                                            <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>معلق</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">حالة الطلب</label>
                                    <p class="mb-0">
                                        <span class="order-badge badge-{{ $order->status }}">
                                            @switch($order->status)
                                                @case('pending') <i class="fas fa-clock me-1"></i>قيد الانتظار @break
                                                @case('approved') <i class="fas fa-check me-1"></i>موافق عليه @break
                                                @case('processing') <i class="fas fa-cog me-1"></i>قيد التجهيز @break
                                                @case('shipped') <i class="fas fa-truck me-1"></i>تم الشحن @break
                                                @case('completed') <i class="fas fa-check-circle me-1"></i>مكتمل @break
                                                @case('cancelled') <i class="fas fa-times-circle me-1"></i>ملغي @break
                                            @endswitch
                                        </span>
                                    </p>
                                </div>
                                @if($order->notes)
                                <div class="mb-0">
                                    <label class="text-muted small">ملاحظات</label>
                                    <p class="mb-0">{{ $order->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Info -->
                        @if($order->payment)
                        <div class="content-card card">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>معلومات الدفع</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <label class="text-muted small">طريقة الدفع</label>
                                    <p class="mb-0 fw-bold">{{ $order->payment->payment_method }}</p>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted small">معرف العملية</label>
                                    <p class="mb-0 text-muted">{{ $order->payment->transaction_id ?? '-' }}</p>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted small">المبلغ</label>
                                    <p class="mb-0 fw-bold text-success">{{ number_format($order->payment->amount, 2) }} ر.س</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column - Items -->
                    <div class="col-md-8">
                        <div class="content-card card">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0"><i class="fas fa-box-open me-2"></i>منتجات الطلب</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="rounded-end">المنتج</th>
                                                <th>السعر</th>
                                                <th>الكمية</th>
                                                <th class="rounded-start">الإجمالي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-light rounded p-2 me-3">
                                                                <i class="fas fa-box text-muted"></i>
                                                            </div>
                                                            <div>
                                                                <strong>{{ $item->product->name }}</strong>
                                                                @if($item->product->sku)
                                                                    <br><small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ number_format($item->price, 2) }} ر.س</td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $item->quantity }}</span>
                                                    </td>
                                                    <td>
                                                        <strong>{{ number_format($item->quantity * $item->price, 2) }}</strong>
                                                        <small class="text-muted">ر.س</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="3" class="text-end">المجموع:</td>
                                                <td><strong>{{ number_format($order->subtotal, 2) }} ر.س</strong></td>
                                            </tr>
                                            @if($order->tax > 0)
                                            <tr>
                                                <td colspan="3" class="text-end">الضريبة ({{ $order->tax_rate }}%):</td>
                                                <td>{{ number_format($order->tax, 2) }} ر.س</td>
                                            </tr>
                                            @endif
                                            @if($order->shipping > 0)
                                            <tr>
                                                <td colspan="3" class="text-end">الشحن:</td>
                                                <td>{{ number_format($order->shipping, 2) }} ر.س</td>
                                            </tr>
                                            @endif
                                            <tr class="table-active">
                                                <td colspan="3" class="text-end fw-bold">الإجمالي:</td>
                                                <td class="fw-bold text-success fs-5">{{ number_format($order->total, 2) }} ر.س</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.orders.reject', $order->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">رفض الطلب #{{ $order->order_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">سبب الرفض</label>
                            <textarea name="reason" class="form-control" rows="3" required placeholder="اكتب سبب الرفض..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">رفض الطلب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
