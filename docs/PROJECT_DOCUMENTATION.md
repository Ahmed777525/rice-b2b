# Rice B2B E-Commerce Platform Documentation

## المرحلة الأولى: إنشاء المشروع ✅ مكتمل

### 1.1 نظرة عامة على البيئة

| المكون | الموقع | الإصدار |
|--------|--------|---------|
| PHP | `C:\laragon\bin\php\php-8.3.26-Win32-vs16-x64` | 8.3.26 |
| Composer | `C:\laragon\bin\composer` | 2.x |
| Laravel | - | 12.0 |
| Laragon | `C:\laragon` | 最新 |

### 1.2 مسار المشروع

```
C:\laragon\www\rice-b2b
```

### 1.3 هيكل المشروع

```
rice-b2b/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # مصادقة المستخدمين
│   │   │   ├── Shop/             # المتجر
│   │   │   ├── DashboardController.php
│   │   │   ├── LocalizationController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   ├── SetLocale.php     # تحديد اللغة
│   │   │   └── RoleMiddleware.php # إدارة الأدوار
│   │   └── Requests/
│   │       ├── Auth/             # طلبات المصادقة
│   │       ├── AddToCartRequest.php
│   │       ├── CheckoutRequest.php
│   │       └── ProductRequest.php
│   ├── Models/
│   │   ├── User.php              # المستخدم مع أدوار
│   │   ├── Branch.php            # الفروع
│   │   ├── Product.php           # المنتجات
│   │   ├── Category.php         # التصنيفات
│   │   ├── ProductPrice.php      # الأسعار
│   │   ├── Stock.php             # المخزون
│   │   ├── Cart.php              # السلة
│   │   ├── CartItem.php          # عناصر السلة
│   │   ├── Order.php             # الطلبات
│   │   └── OrderItem.php         # عناصر الطلب
│   ├── Services/
│   │   ├── CartService.php       # منطق السلة
│   │   └── OrderService.php      # منطق الطلبات
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── View/
│       └── Components/           # مكونات Blade
├── bootstrap/
│   ├── app.php                   # إعداد Laravel 12
│   └── providers.php             # Providers
├── config/
├── database/
│   ├── migrations/               # 13 ملف Migration
│   ├── factories/
│   └── seeders/
├── lang/
│   ├── ar/messages.php           # رسائل عربية
│   └── en/messages.php           # رسائل إنجليزية
├── routes/
│   ├── web.php                   # مسارات الويب
│   └── auth.php                  # مسارات المصادقة
├── resources/
│   └── views/
├── storage/
├── tests/
├── vendor/
├── .env
├── composer.json
└── artisan
```

---

## المرحلة الثانية: قاعدة البيانات

### 2.1 جداول قاعدة البيانات

#### 1. جدول المستخدمين (`users`)
```
php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    
    // B2B Fields
    $table->enum('role', ['admin', 'branch_manager', 'trader'])->default('trader');
    $table->string('company_name')->nullable();
    $table->string('commercial_register')->nullable()->unique();
    $table->string('tax_number')->nullable();
    $table->string('phone')->nullable();
    $table->unsignedBigInteger('branch_id')->nullable();
    $table->boolean('is_active')->default(true);
    
    $table->rememberToken();
    $table->timestamps();
});
```

**الحقول:**
| الحقل | النوع | الوصف |
|-------|-------|-------|
| id | BigInt | مفتاح أساسي |
| name | String | اسم المستخدم |
| email | String | البريد الإلكتروني (فريد) |
| password | String | كلمة المرور (مشفرة) |
| role | Enum | الدور: admin, branch_manager, trader |
| company_name | String | اسم الشركة |
| commercial_register | String | السجل التجاري |
| tax_number | String | الرقم الضريبي |
| phone | String | رقم الجوال |
| branch_id | BigInt | مفتاح الفرع الخارجي |
| is_active | Boolean | حالة التفعيل |

#### 2. جدول الفروع (`branches`)
```
php
Schema::create('branches', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('name_ar');
    $table->string('name_en');
    $table->string('country');
    $table->string('city');
    $table->string('address')->nullable();
    $table->string('phone')->nullable();
    $table->string('currency')->default('SAR');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### 3. جدول التصنيفات (`categories`)
```
php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('name_ar');
    $table->string('name_en');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('image')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### 4. جدول المنتجات (`products`)
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('name_ar');
    $table->string('name_en');
    $table->string('slug')->unique();
    $table->string('sku')->unique();
    $table->string('barcode')->nullable();
    $table->text('description')->nullable();
    $table->text('description_ar')->nullable();
    $table->text('description_en')->nullable();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->string('unit');           // كجم، طن، إلخ
    $table->decimal('unit_weight', 10, 2);
    $table->integer('min_order_quantity')->default(1);
    $table->integer('max_order_quantity')->nullable();
    $table->string('main_image')->nullable();
    $table->json('gallery_images')->nullable();
    $table->boolean('is_active')->default(true);
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_taxable')->default(true);
    $table->decimal('tax_rate', 5, 2)->default(15);
    $table->timestamps();
    $table->softDeletes();
});
```

#### 5. جدول أسعار المنتجات (`product_prices`)
```
php
Schema::create('product_prices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->foreignId('branch_id')->constrained()->onDelete('cascade');
    $table->decimal('unit_price', 12, 2);
    $table->decimal('wholesale_price', 12, 2)->nullable();
    $table->integer('min_wholesale_quantity')->default(10);
    $table->boolean('is_active')->default(true);
    $table->timestamp('price_valid_from')->nullable();
    $table->timestamp('price_valid_to')->nullable();
    $table->timestamps();
    
    $table->unique(['product_id', 'branch_id']);
});
```

#### 6. جدول المخزون (`stocks`)
```
php
Schema::create('stocks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->foreignId('branch_id')->constrained()->onDelete('cascade');
    $table->integer('quantity')->default(0);
    $table->integer('reserved_quantity')->default(0);
    $table->integer('available_quantity')->default(0);
    $table->integer('min_stock_level')->default(10);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    
    $table->unique(['product_id', 'branch_id']);
});
```

#### 7. جدول السلة (`carts`)
```
php
Schema::create('carts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('branch_id')->constrained()->onDelete('cascade');
    $table->decimal('subtotal', 12, 2)->default(0);
    $table->decimal('tax_amount', 12, 2)->default(0);
    $table->decimal('total', 12, 2)->default(0);
    $table->timestamps();
});
```

#### 8. جدول عناصر السلة (`cart_items`)
```
php
Schema::create('cart_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cart_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->integer('quantity')->default(1);
    $table->decimal('unit_price', 12, 2);
    $table->decimal('total_price', 12, 2);
    $table->timestamps();
});
```

#### 9. جدول الطلبات (`orders`)
```
php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_number')->unique();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('branch_id')->constrained()->onDelete('cascade');
    $table->enum('status', [
        'pending', 'approved', 'processing', 
        'shipped', 'completed', 'cancelled', 'rejected'
    ])->default('pending');
    $table->enum('payment_status', [
        'pending', 'paid', 'failed', 'refunded'
    ])->default('pending');
    $table->enum('payment_method', [
        'bank_transfer', 'visa', 'mada', 'paypal'
    ])->nullable();
    $table->string('shipping_address')->nullable();
    $table->string('city')->nullable();
    $table->string('phone')->nullable();
    $table->text('notes')->nullable();
    $table->decimal('subtotal', 12, 2)->default(0);
    $table->decimal('tax_amount', 12, 2)->default(0);
    $table->decimal('shipping_amount', 12, 2)->default(0);
    $table->decimal('discount_amount', 12, 2)->default(0);
    $table->decimal('total', 12, 2)->default(0);
    $table->timestamp('approved_at')->nullable();
    $table->timestamp('processing_at')->nullable();
    $table->timestamp('shipped_at')->nullable();
    $table->timestamp('completed_at')->nullable();
    $table->timestamp('cancelled_at')->nullable();
    $table->string('cancellation_reason')->nullable();
    $table->timestamps();
});
```

#### 10. جدول عناصر الطلب (`order_items`)
```
php
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->string('product_name');
    $table->string('product_sku');
    $table->integer('quantity')->default(1);
    $table->decimal('unit_price', 12, 2);
    $table->decimal('total_price', 12, 2);
    $table->timestamps();
});
```

### 2.2 علاقات قاعدة البيانات

```
Users (1) ──────< (N) Orders
     │
     └─────< (1) Branches

Branches (1) ──────< (N) Products (prices)
                 ──────< (N) Stocks
                 ──────< (N) Orders
                 ──────< (N) Carts

Categories (1) ──────< (N) Products

Products (1) ──────< (N) ProductPrices
               ──────< (N) Stocks
               ──────< (N) CartItems
               ──────< (N) OrderItems

Carts (1) ──────< (N) CartItems

Orders (1) ──────< (N) OrderItems
```

---

## المرحلة الثالثة: نظام المستخدمين والصلاحيات

### 3.1 الأدوار (Roles)

| الدور | الوصف | الصلاحيات |
|-------|-------|----------|
| admin | مدير النظام | كل الصلاحيات |
| branch_manager | مدير الفرع | إدارة فرع واحد |
| trader | تاجر/موزع | عرض المنتجات والشراء |

### 3.2 نموذج المستخدم

```
php
class User extends Authenticatable
{
    // العلاقات
    public function branch(): BelongsTo
    public function orders(): HasMany
    
    // التحقق من الأدوار
    public function hasRole(string $role): bool
    public function isAdmin(): bool
    public function isBranchManager(): bool
    public function isTrader(): bool
}
```

---

## المرحلة الرابعة: الفروع (Multi-Country)

### 4.1 هيكل الفرع

```
php
class Branch extends Model
{
    protected $fillable = [
        'name', 'name_ar', 'name_en',
        'country', 'city', 'address', 'phone',
        'currency', 'is_active'
    ];
}
```

### 4.2 ميزات الفروع

- **دعم_MULTI-COUNTRY**: كل فرع في دولة مختلفة
- **عملة مستقلة**: كل فرع بعملته الخاصة
- **مخزون منفصل**: مخزون مستقل لكل فرع
- **أسعار مستقلة**: أسعار مختلفة لكل فرع

---

## المرحلة الخامسة: نظام المخزون

### 5.1 منطق المخزون

```
الطلب → Pending → الموافقة → Approved → خصم المخزون
                                    ↓
                            Processing → Shipped → Completed
```

### 5.2 التحقق من المخزون

```
php
public function isAvailableInBranch(int $branchId, int $quantity = 1): bool
{
    $stock = $this->getStockForBranch($branchId);
    if (!$stock) return false;
    return $stock->available_quantity >= $quantity;
}
```

---

## المرحلة السادسة: دعم اللغات (Localization)

### 6.1 اللغات المدعومة

| اللغة | الاتجاه | الكود |
|-------|--------|-------|
| العربية | RTL | ar |
| الإنجليزية | LTR | en |

### 6.2 ملفات اللغات

```
lang/
├── ar/messages.php   # رسائل عربية
└── en/messages.php   # رسائل إنجليزية
```

### 6.3 Middleware اللغة

```
php
class SetLocale implements Middleware
{
    public function handle(Request $request, Closure $next)
    {
        // تحديد اللغة من_session أو URL
    }
}
```

---

## المرحلة السابعة: Multi-Tenancy (مستقبلي)

### 7.1 التصميم الحالي Tenant-Aware

النظام مصمم ليكون Tenant-Aware بدون استخدام Packages جاهزة:

1. **الجداول**: جميع الجداول تحتوي على `tenant_id` (مستقبلي)
2. **العلاقات**: العلاقات مبنية على `branch_id` الذي يمثل الوحدة الأساسية
3. **الصلاحيات**: نظام الأدوار مبني على مستوى الفرع

### 7.2 تفعيل Multi-Tenancy مستقبلاً

لتفعيل Multi-Tenancy لاحقاً:

1. **إضافة حقل tenant_id لكل جدول:**
```
php
$table->unsignedBigInteger('tenant_id')->nullable();
```

2. **إنشاء Middleware للـ Tenant:**
```
php
class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = Tenant::find(subdomain);
        Tenancy::setTenant($tenant);
        return $next($request);
    }
}
```

3. **تحديث الاستعلامات:**
```
php
// استخدام scope
public function scopeTenant($query)
{
    return $query->where('tenant_id', Tenancy::getTenantId());
}
```

---

## المرحلة الثامنة: البنية التقنية

### 8.1 Laravel 12 المميزات

| الميزة | الحالة | الملاحظات |
|--------|--------|----------|
| Bootstrap/app.php | ✅ مستخدم | الإعداد الجديد |
| without Middleware Kernel | ✅ | باستخدام withMiddleware() |
| withRouting() | ✅ | في bootstrap/app.php |
| withExceptions() | ✅ | إدارة الأخطاء |

### 8.2 الخدمات (Services)

```
php
app/Services/
├── CartService.php    # منطق السلة
└── OrderService.php   # منطق الطلبات
```

### 8.3 الطلبات (Requests)

```
php
app/Http/Requests/
├── Auth/LoginRequest.php
├── AddToCartRequest.php
├── CheckoutRequest.php
├── ProductRequest.php
└── CategoryRequest.php
```

---

## المرحلة التاسعة: Routes

### 9.1 مسارات الويب

```php
//_switch اللغة
Route::get('language/{locale}', ...)->name('language.switch');

//_general
Route::get('/', ...)->name('home');

//المتجر (عام)
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', ...)->name('products.index');
    Route::get('/products/{slug}', ...)->name('products.show');
});

//_محمي (يتطلب تسجيل)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', ...)->name('dashboard');
    
    // Cart
    Route::prefix('cart')->name('shop.cart.')->group(...);
    
    // Checkout
    Route::prefix('checkout')->name('shop.checkout.')->group(...);
    
    // Orders
    Route::prefix('orders')->name('shop.orders.')->group(...);
    
    // Profile
    Route::prefix('profile')->name('profile.')->group(...);
});

//_المصادقة
require __DIR__.'/auth.php';
```

---

## المرحلة العاشرة:下一步 (التالي)

###_pending Tasks

1. ⏳ إعداد قاعدة البيانات (MySQL)
2. ⏳ تشغيل Migrations
3. ⏳ تشغيل Seeders
4. ⏳ إعداد Payment Gateway
5. ⏳ إنشاء Admin Panel
6. ⏳ تحسينات أمنية
7. ⏳ الاختبار النهائي

---

**تاريخ الإنشاء:** 2026
**الإصدار:** 1.0
**الحالة:** مشروع Laravel 12 جاهز
