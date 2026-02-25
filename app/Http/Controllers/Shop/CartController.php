<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Http\Requests\AddToCartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        // Middleware auth موجود مسبقاً في Route، لا حاجة هنا
    }

    // عرض محتويات السلة
    public function index()
    {
        $cart = $this->cartService->getCurrentCart();
        $summary = $this->cartService->getCartSummary();

        return view('shop.cart.index', compact('cart', 'summary'));
    }

    // إضافة منتج للسلة
    public function add(AddToCartRequest $request)
    {
        $result = $this->cartService->addToCart($request->product_id, $request->quantity);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->route('shop.cart.index')
                ->with('success', __('messages.product_added_to_cart'));
        }

        return back()->with('error', __("messages.{$result['message']}"));
    }

    // تحديث الكمية
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $result = $this->cartService->updateQuantity($itemId, $request->quantity);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->route('shop.cart.index')
                ->with('success', __('messages.cart_updated'));
        }

        return back()->with('error', __("messages.{$result['message']}"));
    }

    // حذف منتج
    public function remove(Request $request, $itemId)
    {
        $result = $this->cartService->removeItem($itemId);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->route('shop.cart.index')
                ->with('success', __('messages.item_removed'));
        }

        return back()->with('error', __("messages.{$result['message']}"));
    }

    // تفريغ السلة
    public function clear(Request $request)
    {
        $result = $this->cartService->clearCart();

        if ($request->ajax()) {
            return response()->json($result);
        }

        return redirect()->route('shop.cart.index')
            ->with('success', __('messages.cart_cleared'));
    }

    // عدد المنتجات في السلة
    public function count()
    {
        $summary = $this->cartService->getCartSummary();

        return response()->json(['count' => $summary['items_count']]);
    }
}
