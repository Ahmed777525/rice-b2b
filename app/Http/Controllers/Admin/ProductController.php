<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * قائمة المنتجات
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'prices', 'stocks.branch']);

        // البحث
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%");
        }

        // فلترة حسب التصنيف
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // فلترة حسب الحالة
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $products = $query->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * إضافة منتج جديد
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * حفظ منتج جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'sku' => 'required|string|unique:products',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'name_ar' => $validated['name'],
            'name_en' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'sku' => $validated['sku'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'category_id' => null,
        ]);

        // إضافة السعر الأساسي
        if ($request->has('price') && $request->price) {
            $branches = \App\Models\Branch::all();
            foreach ($branches as $branch) {
                \App\Models\ProductPrice::create([
                    'product_id' => $product->id,
                    'branch_id' => $branch->id,
                    'price' => $request->price,
                    'cost' => $request->cost_price ?? 0,
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * عرض تفاصيل المنتج
     */
    public function show($id)
    {
        $product = Product::with(['category', 'prices', 'stocks.branch'])
            ->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    /**
     * تعديل المنتج
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * تحديث المنتج
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // تحديث بيانات المنتج الأساسية
        $product->update([
            'name' => $validated['name'],
            'name_ar' => $request->name_ar ?? $validated['name'],
            'name_en' => $request->name_en ?? $validated['name'],
            'description' => $validated['description'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // تحديث الأسعار إذا تم توفيرها
        if ($request->has('price') && $request->price) {
            $branches = \App\Models\Branch::all();
            foreach ($branches as $branch) {
                $price = \App\Models\ProductPrice::where('product_id', $product->id)
                    ->where('branch_id', $branch->id)
                    ->first();
                
                if ($price) {
                    $price->update([
                        'price' => $request->price,
                        'cost' => $request->cost_price ?? $price->cost,
                    ]);
                } else {
                    \App\Models\ProductPrice::create([
                        'product_id' => $product->id,
                        'branch_id' => $branch->id,
                        'price' => $request->price,
                        'cost' => $request->cost_price ?? 0,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * حذف المنتج
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // التحقق من عدم وجود طلبات مرتبطة
        if ($product->orderItems()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف المنتج لوجود طلبات مرتبطة');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}