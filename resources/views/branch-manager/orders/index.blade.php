<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطلبات - لوحة تحكم الفرع</title>
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
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 15px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 8px; margin-bottom: 5px; transition: alls; }
        .sidebar-menu a 0.3:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-menu a i { width: 25px; margin-left: 10px; }
        .content-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .order-badge { padding: 8px 15px; border-radius: 20px; font-size: 0.85rem; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-approved { background: #dbeafe; color: #2563eb; }
        .badge-processing { background: #e0e7ff; color: #4f46e5; }
        .badge-shipped { background: #f3e8ff; color: #9333ea; }
        .badge-completed { background: #d1fae5; color: #059669; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; }
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
                <h2 class="mb-4">الطلبات</h2>

                <!-- Filters -->
                <div class="content-card card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">بحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="رقم الطلب أو العميل" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="">الكل</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلق</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد التجهيز</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="content-card card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-primary">{{ $order->order_number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td class="fw-bold">{{ number_format($order->total, 2) }} ر.س</td>
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
                                    <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <a href="{{ route('branch.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">لا توجد طلبات</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
