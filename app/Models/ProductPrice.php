<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    use HasFactory;

    protected $table = 'product_prices';

    protected $fillable = [
        'product_id', 'branch_id', 'price', 'cost',
        'wholesale_price', 'wholesale_min_quantity',
        'price_valid_from', 'price_valid_to', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_valid_from' => 'date',
        'price_valid_to' => 'date',
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
    ];

    /**
     * العلاقات
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * الحصول على السعر المناسب حسب الكمية
     */
    public function getPriceForQuantity(int $quantity): float
    {
        if ($this->wholesale_price && $quantity >= $this->wholesale_min_quantity) {
            return $this->wholesale_price;
        }
        
        return $this->price;
    }

    /**
     * السعر شامل الضريبة
     */
    public function getPriceWithTaxAttribute(): float
    {
        if (!$this->product->is_taxable) {
            return $this->price;
        }
        
        return $this->price * (1 + ($this->product->tax_rate / 100));
    }

    /**
     * الحصول على نسبة الخصم
     */
    public function getDiscountPercentageAttribute(): float
    {
        // إذا كان هناك تخفيض على السعر (يمكنك إضافة حقل discount_price في الجدول)
        //，但现在我们简单计算
        return 0;
    }

    /**
     * الحصول على السعر النهائي بعد الخصم
     */
    public function getFinalPriceAttribute(): float
    {
        return $this->price;
    }
}
