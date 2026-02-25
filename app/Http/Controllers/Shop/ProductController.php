<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * عرض قائمة المنتجات
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'prices' => function($q) {
            if (Auth::check() && Auth::user()->branch_id) {
                $q->where('branch_id', Auth::user()->branch_id);
            }
        }])->where('is_active', true);

        // تصفية حسب التصنيف
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // بحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('shop.products.index', compact('products', 'categories'));
    }

    /**
     * عرض تفاصيل المنتج
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'prices' => function($q) {
            if (Auth::check() && Auth::user()->branch_id) {
                $q->where('branch_id', Auth::user()->branch_id);
            }
        }])->where('slug', $slug)
          ->where('is_active', true)
          ->firstOrFail();

        // الحصول على مخزون الفرع إذا كان المستخدم مسجل
        $stock = null;
        $price = null;
        
        if (Auth::check() && Auth::user()->branch_id) {
            $branchId = Auth::user()->branch_id;
            $stock = $product->getStockForBranch($branchId);
            $price = $product->getPriceForBranch($branchId);
        }

        // منتجات ذات صلة
        $relatedProducts = Product::with(['category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('shop.products.show', compact('product', 'stock', 'price', 'relatedProducts'));
    }
}