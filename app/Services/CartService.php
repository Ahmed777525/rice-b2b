<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartService
{
    // Alias for getCurrentCart
    public function getCart(): ?Cart
    {
        return $this->getCurrentCart();
    }

    public function getCurrentCart(): ?Cart
    {
        $user = Auth::user();
        if (!$user) return null;

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if ($cart && !$cart->isValid()) {
            $cart->clear();
        }

        return $cart;
    }

    public function createCart(): Cart
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)->delete();

        return Cart::create([
            'user_id' => $user->id,
            'branch_id' => $user->branch_id,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function addToCart(int $productId, int $quantity): array
    {
        return DB::transaction(function () use ($productId, $quantity) {
            $user = Auth::user();
            $product = Product::findOrFail($productId);

            $price = $product->getPriceForBranch($user->branch_id);
            if (!$price) return ['success' => false, 'message' => 'product_price_not_available'];

            $stock = $product->getStockForBranch($user->branch_id);
            if (!$stock || $stock->available_quantity < $quantity) {
                return ['success' => false, 'message' => 'insufficient_stock'];
            }

            if ($quantity < $product->min_order_quantity) {
                return ['success' => false, 'message' => 'min_order_quantity_not_met'];
            }

            if ($product->max_order_quantity && $quantity > $product->max_order_quantity) {
                return ['success' => false, 'message' => 'max_order_quantity_exceeded'];
            }

            $cart = $this->getCurrentCart();
            if (!$cart || $cart->branch_id != $user->branch_id) {
                $cart = $this->createCart();
            }

            // البحث عن المنتج داخل السلة
            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
                if ($stock->available_quantity < $newQuantity) {
                    return ['success' => false, 'message' => 'insufficient_stock'];
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->is_wholesale = $price->wholesale_price && $newQuantity >= $price->wholesale_min_quantity;
                $cartItem->updateTotals();
            } else {
                $cartItem = CartItem::createFromProduct($product, $price, $quantity, $cart->id);
                $cart->items()->save($cartItem);
            }

            $stock->reserve($quantity);
            $cart->recalculateTotals();

            return [
                'success' => true,
                'message' => 'product_added_to_cart',
                'cart' => $cart->load('items.product'),
                'cart_count' => $cart->items_count
            ];
        });
    }

    // --- تحديث الكمية ---
    public function updateQuantity(int $cartItemId, int $quantity): array
    {
        return DB::transaction(function () use ($cartItemId, $quantity) {
            $cartItem = CartItem::with('product')->findOrFail($cartItemId);
            $cart = $cartItem->cart;
            $user = Auth::user();

            if ($cart->user_id !== $user->id) return ['success' => false, 'message' => 'unauthorized'];

            $product = $cartItem->product;
            $stock = $product->getStockForBranch($user->branch_id);

            if ($quantity == 0) {
                $stock?->unreserve($cartItem->quantity);
                $cartItem->delete();
            } else {
                $diff = $quantity - $cartItem->quantity;
                if ($diff > 0 && (!$stock || $stock->available_quantity < $diff)) {
                    return ['success' => false, 'message' => 'insufficient_stock'];
                }
                $diff > 0 ? $stock->reserve($diff) : $stock->unreserve(abs($diff));

                if ($quantity < $product->min_order_quantity) return ['success' => false, 'message' => 'min_order_quantity_not_met'];

                $cartItem->quantity = $quantity;
                $price = $product->getPriceForBranch($user->branch_id);
                $cartItem->is_wholesale = $price?->wholesale_price && $quantity >= $price->wholesale_min_quantity;
                $cartItem->updateTotals();
            }

            $cart->recalculateTotals();
            return [
                'success' => true,
                'message' => $quantity == 0 ? 'item_removed' : 'quantity_updated',
                'cart' => $cart->load('items.product'),
                'cart_count' => $cart->items_count
            ];
        });
    }

    // --- حذف عنصر ---
    public function removeItem(int $cartItemId): array
    {
        return DB::transaction(function () use ($cartItemId) {
            $cartItem = CartItem::findOrFail($cartItemId);
            $cart = $cartItem->cart;
            $user = Auth::user();

            if ($cart->user_id !== $user->id) return ['success' => false, 'message' => 'unauthorized'];

            $stock = $cartItem->product->getStockForBranch($user->branch_id);
            $stock?->unreserve($cartItem->quantity);

            $cartItem->delete();
            $cart->recalculateTotals();

            return ['success' => true, 'message' => 'item_removed', 'cart' => $cart->load('items.product'), 'cart_count' => $cart->items_count];
        });
    }

    // --- تفريغ السلة ---
    public function clearCart(): array
    {
        return DB::transaction(function () {
            $cart = $this->getCurrentCart();
            if ($cart) {
                foreach ($cart->items as $item) {
                    $stock = $item->product->getStockForBranch($cart->branch_id);
                    $stock?->unreserve($item->quantity);
                }
                $cart->clear();
            }

            return ['success' => true, 'message' => 'cart_cleared'];
        });
    }

    // --- ملخص السلة ---
    public function getCartSummary(): array
    {
        $cart = $this->getCurrentCart();
        if (!$cart) return ['items_count'=>0,'subtotal'=>0,'tax'=>0,'total'=>0,'items'=>[]];

        return [
            'items_count' => $cart->items_count,
            'subtotal' => $cart->subtotal,
            'tax' => $cart->tax,
            'total' => $cart->total,
            'items' => $cart->items->map(fn($item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->localized_name,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'wholesale_price' => $item->wholesale_price,
                'is_wholesale' => $item->is_wholesale,
                'subtotal' => $item->subtotal,
                'tax' => $item->tax,
                'total' => $item->total,
                'image' => $item->product->main_image,
                'sku' => $item->product->sku,
            ])
        ];
    }
}
