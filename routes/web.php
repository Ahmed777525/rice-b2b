<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\BranchManager\DashboardController as BranchManagerDashboardController;
use App\Http\Controllers\BranchManager\OrderController as BranchManagerOrderController;
use App\Http\Controllers\BranchManager\StockController as BranchManagerStockController;
use App\Http\Controllers\PagesController;

// ---------------------------
// Language Switch
// ---------------------------
Route::get('language/{locale}', [LocalizationController::class, 'switch'])
    ->name('language.switch');

// ---------------------------
// Public Routes
// ---------------------------
Route::get('/', function () {
    // جلب أحدث المنتجات للصفحة الرئيسية
    $products = \App\Models\Product::with(['prices', 'stocks', 'category'])
        ->latest()
        ->take(10)
        ->get();
    
    return view('welcome', compact('products'));
})->name('home');

// Page Routes
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/privacy', [PagesController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PagesController::class, 'terms'])->name('terms');

// Shop Routes (Products visible to guests)
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
});

// ---------------------------
// Protected Routes (require auth & verified)
// ---------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cart Routes
    Route::prefix('cart')->name('shop.cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update/{itemId}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{itemId}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });

    // Checkout Routes
    Route::prefix('checkout')->name('shop.checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/callback', [CheckoutController::class, 'callback'])->name('callback');
        Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
    });

    // Orders Routes
    Route::prefix('orders')->name('shop.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('invoice');
    });

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Auth routes
require __DIR__.'/auth.php';

// ---------------------------
// Admin Routes (Admin & Branch Manager)
// ---------------------------
Route::middleware(['auth', 'verified', 'role:admin|branch_manager'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Orders Management
    Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderManagementController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/approve', [OrderManagementController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{id}/reject', [OrderManagementController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/export', [OrderManagementController::class, 'export'])->name('orders.export');
    
    // Branches Management
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
    Route::get('/branches/create', [BranchController::class, 'create'])->name('branches.create');
    Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
    Route::get('/branches/{id}', [BranchController::class, 'show'])->name('branches.show');
    Route::get('/branches/{id}/edit', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('/branches/{id}', [BranchController::class, 'update'])->name('branches.update');
    Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');
    
    // Products Management
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Stock Management
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/{id}/edit', [StockController::class, 'edit'])->name('stocks.edit');
    Route::put('/stocks/{id}', [StockController::class, 'update'])->name('stocks.update');
    Route::post('/stocks/add', [StockController::class, 'addStock'])->name('stocks.add');
    
    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/reports/export-sales', [ReportController::class, 'exportSales'])->name('reports.export-sales');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::post('/settings/general', [SettingsController::class, 'general']);
    Route::get('/settings/branches', [SettingsController::class, 'branches'])->name('settings.branches');
    Route::post('/settings/branches', [SettingsController::class, 'branches']);
    Route::get('/settings/stock', [SettingsController::class, 'stock'])->name('settings.stock');
    Route::post('/settings/stock', [SettingsController::class, 'stock']);
    Route::get('/settings/orders', [SettingsController::class, 'orders'])->name('settings.orders');
    Route::post('/settings/orders', [SettingsController::class, 'orders']);
    Route::get('/settings/payment', [SettingsController::class, 'payment'])->name('settings.payment');
    Route::post('/settings/payment', [SettingsController::class, 'payment']);
    Route::get('/settings/mail', [SettingsController::class, 'mail'])->name('settings.mail');
    Route::post('/settings/mail', [SettingsController::class, 'mail']);
    Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
});

// ---------------------------
// Branch Manager Routes (Only Branch Manager Role)
// ---------------------------
Route::middleware(['auth', 'verified', 'role:branch_manager'])->prefix('branch')->name('branch.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [BranchManagerDashboardController::class, 'index'])->name('dashboard');
    
    // Orders Management (Branch specific)
    Route::get('/orders', [BranchManagerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [BranchManagerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/approve', [BranchManagerOrderController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{id}/reject', [BranchManagerOrderController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{id}/status', [BranchManagerOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Stock Management (Branch specific)
    Route::get('/stocks', [BranchManagerStockController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/{id}/edit', [BranchManagerStockController::class, 'edit'])->name('stocks.edit');
    Route::put('/stocks/{id}', [BranchManagerStockController::class, 'update'])->name('stocks.update');
    Route::post('/stocks/add', [BranchManagerStockController::class, 'addStock'])->name('stocks.add');
});
