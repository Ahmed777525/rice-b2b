<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطلبات - لوحة التحكم</title>
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
        .stat-card { border: none; border-radius: 15px; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .order-badge { padding: 8px 15px; border-radius: 20px; font-size: 0.85rem; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-approved { background: #dbeafe; color: #2563eb; }
        .badge-processing { background: #e0e7ff; color: #4f46e5; }
        .badge-shipped { background: #f3e8ff; color: #9333ea; }
        .badge-completed { background: #d1fae5; color: #059669; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; }
        .table-header { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: white; }
        .action-btn { width: 35px; height: 35px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
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
                    <h2><i class="fas fa-shopping-cart me-2"></i>الطلبات</h2>
                    <div>
                        <button class="btn btn-success me-2" onclick="exportOrders()">
                            <i class="fas fa-download me-1"></i> تصدير
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card text-white bg-warning mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">قيد الانتظار</h6>
                                        <h3 class="mb-0">{{ $orders->where('status', 'pending')->count() }}</h3>
                                    </div>
                                    <i class="fas fa-clock fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card text-white bg-info mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">قيد التجهيز</h6>
                                        <h3 class="mb-0">{{ $orders->where('status', 'processing')->count() }}</h3>
                                    </div>
                                    <i class="fas fa-cog fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card text-white bg-primary mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">تم الشحن</h6>
                                        <h3 class="mb-0">{{ $orders->where('status', 'shipped')->count() }}</h3>
                                    </div>
                                    <i class="fas fa-truck fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card text-white bg-success mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">مكتملة</h6>
                                        <h3 class="mb-0">{{ $orders->where('status', 'completed')->count() }}</h3>
                                    </div>
                                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="content-card card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">بحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="رقم الطلب أو العميل" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="">الكل</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد التجهيز</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">الفرع</label>
                                <select name="branch_id" class="form-select">
                                    <option value="">الكل</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">إلى تاريخ</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
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
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th class="rounded-end">رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>الفرع</th>
                                        <th>عدد المنتجات</th>
                                        <th>الإجمالي</th>
                                        <th>الدفع</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                        <th class="rounded-start">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none fw-bold">
                                                    #{{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary text-white me-2">
                                                        {{ substr($order->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $order->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $order->user->phone }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-store me-1"></i>{{ $order->branch->name }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-box me-1"></i>{{ $order->items->count() }} منتج
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ number_format($order->total, 2) }}</strong>
                                                <small class="text-muted">ر.س</small>
                                            </td>
                                            <td>
                                                @if($order->payment_status == 'paid')
                                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>مدفوع</span>
                                                @else
                                                    <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>معلق</span>
                                                @endif
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $order->created_at->format('Y/m/d') }}</small>
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                       class="btn btn-sm btn-outline-primary action-btn" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($order->status == 'pending')
                                                        <form method="POST" action="{{ route('admin.orders.approve', $order->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-success action-btn" title="موافقة">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-outline-danger action-btn"
                                                                data-bs-toggle="modal" data-bs-target="#rejectModal{{ $order->id }}" title="رفض">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                    @if(in_array($order->status, ['approved', 'processing']))
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary action-btn dropdown-toggle" 
                                                                    data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
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
                                            </td>
                                        </tr>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $order->id }}" tabindex="-1">
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
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">لا توجد طلبات</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function exportOrders() {
            window.location.href = '{{ route("admin.orders.export") }}';
        }
    </script>
</body>
</html>
