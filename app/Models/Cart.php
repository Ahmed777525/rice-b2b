<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'branch_id', 'session_id', 'subtotal',
        'tax', 'total', 'items_count', 'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * العلاقات
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * إعادة حساب إجماليات السلة
     */
    public function recalculateTotals(): void
    {
        $this->load('items');
        
        $this->subtotal = $this->items->sum('subtotal');
        $this->tax = $this->items->sum('tax');
        $this->total = $this->items->sum('total');
        $this->items_count = $this->items->sum('quantity');
        
        $this->save();
    }

    /**
     * تفريغ السلة
     */
    public function clear(): void
    {
        $this->items()->delete();
        $this->subtotal = 0;
        $this->tax = 0;
        $this->total = 0;
        $this->items_count = 0;
        $this->save();
    }

    /**
     * التحقق من صلاحية السلة
     */
    public function isValid(): bool
    {
        return !$this->expires_at || $this->expires_at->isFuture();
    }
}