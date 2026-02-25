<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price',
        'wholesale_price',
        'is_wholesale',
        'product_snapshot',
        'subtotal',
        'tax',
        'total',
    ];

    protected $casts = [
        'product_snapshot' => 'array',
        'is_wholesale' => 'boolean',
    ];

    /**
     * إنشاء item جديد مع لقطة من المنتج
     */
    public static function createFromProduct(Product $product, ProductPrice $price, int $quantity, int $cartId): self
    {
        if (!$price) {
            throw new \Exception("لا توجد أسعار للمنتج: {$product->name}");
        }

        $isWholesale = $price->wholesale_price && $quantity >= $price->wholesale_min_quantity;

        $item = new static([
            'cart_id' => $cartId,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $price->price,
            'wholesale_price' => $price->wholesale_price,
            'is_wholesale' => $isWholesale,
            'product_snapshot' => [
                'name' => $product->name,
                'name_ar' => $product->name_ar ?? $product->name,
                'name_en' => $product->name_en ?? $product->name,
                'sku' => $product->sku,
                'unit' => $product->unit,
                'unit_weight' => $product->unit_weight,
                'tax_rate' => $product->tax_rate ?? 15,
                'is_taxable' => $product->is_taxable ?? true,
                'image' => $product->image,
            ],
        ]);

        $item->updateTotals();

        return $item;
    }

    /**
     * تحديث المجموعات الفرعية والضرائب والإجمالي
     */
    public function updateTotals(): void
    {
        $price = $this->is_wholesale ? $this->wholesale_price : $this->unit_price;
        $this->subtotal = $this->quantity * $price;

        $taxRate = $this->product_snapshot['tax_rate'] ?? 15;
        $this->tax = $this->subtotal * ($taxRate / 100);

        $this->total = $this->subtotal + $this->tax;
        $this->save();
    }

    /**
     * العلاقة مع المنتج
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
