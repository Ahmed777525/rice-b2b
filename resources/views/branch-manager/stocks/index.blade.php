<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المخزون - لوحة تحكم الفرع</title>
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
        .stock-low { background: #fee2e2; color: #dc2626; }
        .stock-available { background: #d1fae5; color: #059669; }
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
                    <a href="{{ route('branch.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>الطلبات</span>
                    </a>
                    <a href="{{ route('branch.stocks.index') }}" class="active">
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
                <h2 class="mb-4">المخزون</h2>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Filters -->
                <div class="content-card card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">بحث</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="اسم المنتج" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="">الكل</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متوفر</option>
                                    <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>منخفض</option>
                                    <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>نفد</option>
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

                <!-- Stocks Table -->
                <div class="content-card card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>م</th>
                                    <th>المنتج</th>
                                    <th>الكمية المتوفرة</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks as $stock)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $stock->product->name }}</td>
                                    <td class="fw-bold">{{ $stock->available_quantity }}</td>
                                    <td>
                                        @if($stock->available_quantity <= 0)
                                            <span class="badge bg-danger">نفد</span>
                                        @elseif($stock->available_quantity <= 10)
                                            <span class="badge stock-low">منخفض</span>
                                        @else
                                            <span class="badge stock-available">متوفر</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('branch.stocks.edit', $stock->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">لا توجد منتجات في المخزون</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $stocks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
