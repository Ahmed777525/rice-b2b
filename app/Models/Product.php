<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'name_ar', 'name_en', 'slug', 'sku', 'barcode',
        'description', 'description_ar', 'description_en',
        'category_id', 'unit', 'unit_weight', 'min_order_quantity',
        'max_order_quantity', 'main_image', 'gallery_images',
        'is_active', 'is_featured', 'is_taxable', 'tax_rate'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_taxable' => 'boolean',
        'gallery_images' => 'array',
        'unit_weight' => 'decimal:2',
        'tax_rate' => 'decimal:2',
    ];

    /**
     * العلاقات
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    /**
     * الحصول على سعر المنتج لفرع معين
     */
    public function getPriceForBranch(int $branchId): ?ProductPrice
    {
        return $this->prices()
            ->where('branch_id', $branchId)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('price_valid_from')
                    ->orWhere('price_valid_from', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('price_valid_to')
                    ->orWhere('price_valid_to', '>=', now());
            })
            ->first();
    }

    /**
     * الحصول على المخزون لفرع معين
     */
    public function getStockForBranch(int $branchId): ?Stock
    {
        return $this->stocks()
            ->where('branch_id', $branchId)
            ->first();
    }

    /**
     * التحقق من توفر الكمية في فرع معين
     */
    public function isAvailableInBranch(int $branchId, int $quantity = 1): bool
    {
        $stock = $this->getStockForBranch($branchId);
        
        if (!$stock) {
            return false;
        }
        
        return $stock->available_quantity >= $quantity;
    }

    /**
     * الحصول على الاسم حسب اللغة
     */
    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * الحصول على الوصف حسب اللغة
     */
    public function getLocalizedDescriptionAttribute(): ?string
    {
        if (app()->getLocale() == 'ar') {
            return $this->description_ar ?? $this->description;
        }
        return $this->description_en ?? $this->description;
    }
}