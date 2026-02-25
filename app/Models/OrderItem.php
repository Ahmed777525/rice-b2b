<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'product_sku',
        'product_unit', 'quantity', 'unit_price', 'wholesale_price',
        'is_wholesale', 'subtotal', 'tax', 'total', 'product_snapshot'
    ];

    protected $casts = [
        'is_wholesale' => 'boolean',
        'product_snapshot' => 'array',
        'unit_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * العلاقات
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}