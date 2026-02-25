<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * قائمة المخزون
     */
    public function index(Request $request)
    {
        $query = Stock::with(['product', 'branch']);

        // فلترة حسب المنتج
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // فلترة حسب الفرع
        if ($request->has('branch_id') && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // فلترة المخزون المنخفض
        if ($request->has('low_stock')) {
            $query->whereRaw('quantity <= reserved_quantity + 10');
        }

        $stocks = $query->latest()->paginate(20);
        $products = Product::all();
        $branches = Branch::all();

        return view('admin.stocks.index', compact('stocks', 'products', 'branches'));
    }

    /**
     * تعديل المخزون
     */
    public function edit($id)
    {
        $stock = Stock::with(['product', 'branch'])->findOrFail($id);
        return view('admin.stocks.edit', compact('stock'));
    }

    /**
     * تحديث المخزون
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:0',
            'reserved_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $stock->update($request->all());

        return redirect()->route('admin.stocks.index')
            ->with('success', 'تم تحديث المخزون بنجاح');
    }

    /**
     * إضافة مخزون
     */
    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // البحث عن مخزون موجود
        $stock = Stock::where('product_id', $request->product_id)
            ->where('branch_id', $request->branch_id)
            ->first();

        if ($stock) {
            $stock->increment('quantity', $request->quantity);
        } else {
            Stock::create([
                'product_id' => $request->product_id,
                'branch_id' => $request->branch_id,
                'quantity' => $request->quantity,
                'reserved_quantity' => 0,
                'reorder_level' => 10,
            ]);
        }

        return back()->with('success', 'تم إضافة المخزون بنجاح');
    }
}
