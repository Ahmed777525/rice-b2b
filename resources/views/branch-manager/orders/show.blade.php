<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الطلب - لوحة تحكم الفرع</title>
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="logo">
                    <i class="fas fa-sack-grain"></i>
                    <h4>لوحة الفرع</h4>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('branch.dashboard') }}">
                        <i class="fas fa-th-large"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    <a href="{{ route('branch.orders.index') }}" class="active">
                        <i class="fas fa-shopping-cart"></i>
                        <span>الطلبات</span>
                    </a>
                    <a href="{{ route('branch.stocks.index') }}">
                        <i class="fas fa-warehouse"></i>
                        <span>المخزون</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger w-100 text-end" style="text-decoration: none;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>طلب #{{ $order->order_number }}</h2>
                    <a href="{{ route('branch.orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> رجوع
                    </a>
                </div>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <!-- Order Info -->
                    <div class="col-md-6">
                        <div class="content-card card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">معلومات الطلب</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>رقم الطلب:</strong></td>
                                        <td>{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>الحالة:</strong></td>
                                        <td>
                                            <span class="order-badge badge-{{ $order->status }}">
                                                @switch($order->status)
                                                    @case('pending') معلق @break
                                                    @case('approved') موافق عليه @break
                                                    @case('processing') قيد التجهيز @break
                                                    @case('shipped') تم الشحن @break
                                                    @case('completed') مكتمل @break
                                                    @case('cancelled') ملغي @break
                                                @endswitch
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>تاريخ الطلب:</strong></td>
                                        <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>طريقة الدفع:</strong></td>
                                        <td>{{ $order->payment_method == 'online' ? 'دفع إلكتروني' : 'دفع عند الاستلام' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>حالة الدفع:</strong></td>
                                        <td>
                                            @if($order->payment_status == 'paid')
                                                <span class="badge bg-success">مدفوع</span>
                                            @else
                                                <span class="badge bg-warning">معلق</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="col-md-6">
                        <div class="content-card card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">معلومات العميل</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>الاسم:</strong></td>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>الهاتف:</strong></td>
                                        <td>{{ $order->user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>البريد:</strong></td>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>العنوان:</strong></td>
                                        <td>{{ $order->shipping_address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="content-card card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">المنتجات</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ number_format($item->price, 2) }} ر.س</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price * $item->quantity, 2) }} ر.س</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>المجموع:</strong></td>
                                    <td><strong>{{ number_format($order->total, 2) }} ر.س</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                @if($order->status == 'pending')
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('branch.orders.approve', $order->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check"></i> موافقة على الطلب
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times"></i> رفض الطلب
                        </button>
                    </div>
                </div>
                @endif

                @if(in_array($order->status, ['approved', 'processing']))
                <form method="POST" action="{{ route('branch.orders.update-status', $order->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                @if($order->status == 'approved')
                                <option value="processing">بدء التجهيز</option>
                                @endif
                                @if($order->status == 'processing')
                                <option value="shipped">شحن الطلب</option>
                                @endif
                                @if($order->status == 'shipped')
                                <option value="completed">تسليم كامل</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> تحديث الحالة
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('branch.orders.reject', $order->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">رفض الطلب</h5>
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
