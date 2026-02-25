<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'branch_id', 'quantity', 'reserved_quantity',
        'reorder_level', 'max_stock_level', 'location_in_warehouse',
        'last_stock_take'
    ];

    protected $casts = [
        'last_stock_take' => 'date',
        'quantity' => 'integer',
        'reserved_quantity' => 'integer',
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
     * الكمية المتاحة (معالجة إذا كانت generated column لا تعمل)
     */
    public function getAvailableQuantityAttribute(): int
    {
        return $this->quantity - $this->reserved_quantity;
    }

    /**
     * التحقق من وجود كمية كافية
     */
    public function hasSufficientQuantity(int $quantity): bool
    {
        return $this->available_quantity >= $quantity;
    }

    /**
     * حجز كمية
     */
    public function reserve(int $quantity): bool
    {
        if (!$this->hasSufficientQuantity($quantity)) {
            return false;
        }
        
        $this->reserved_quantity += $quantity;
        return $this->save();
    }

    /**
     * إلغاء حجز كمية
     */
    public function unreserve(int $quantity): bool
    {
        $this->reserved_quantity = max(0, $this->reserved_quantity - $quantity);
        return $this->save();
    }

    /**
     * خصم كمية (بعد تأكيد الطلب)
     */
    public function deduct(int $quantity): bool
    {
        if (!$this->hasSufficientQuantity($quantity)) {
            return false;
        }
        
        $this->quantity -= $quantity;
        $this->reserved_quantity -= $quantity;
        
        return $this->save();
    }

    /**
     * التحقق من وصول المخزون للحد الأدنى
     */
    public function isLowStock(): bool
    {
        return $this->available_quantity <= $this->reorder_level;
    }

    /**
     * التحقق من وصول المخزون للحد الأقصى
     */
    public function isOverStock(): bool
    {
        if (!$this->max_stock_level) {
            return false;
        }
        
        return $this->quantity >= $this->max_stock_level;
    }
}