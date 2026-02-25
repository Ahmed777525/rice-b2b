<?php

namespace App\Http\Controllers\BranchManager;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display branch stocks
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        if (!$branchId) {
            return redirect()->route('branch.dashboard')->with('error', 'لم يتم تعيين فرع لك');
        }

        $query = Stock::where('branch_id', $branchId)
            ->with(['product', 'branch']);

        // Filter by product name
        if ($request->has('search') && $request->search) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by stock status (using quantity - reserved_quantity = available)
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'low':
                    $query->whereRaw('(quantity - reserved_quantity) <= 10');
                    break;
                case 'out':
                    $query->whereRaw('(quantity - reserved_quantity) = 0');
                    break;
                case 'available':
                    $query->whereRaw('(quantity - reserved_quantity) > 10');
                    break;
            }
        }

        $stocks = $query->latest()->paginate(20);

        return view('branch-manager.stocks.index', compact('stocks'));
    }

    /**
     * Display stock edit form
     */
    public function edit($id)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $stock = Stock::where('id', $id)
            ->where('branch_id', $branchId)
            ->with(['product', 'branch'])
            ->firstOrFail();

        return view('branch-manager.stocks.edit', compact('stock'));
    }

    /**
     * Update stock
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $stock = Stock::where('id', $id)
            ->where('branch_id', $branchId)
            ->firstOrFail();

        $stock->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('branch.stocks.index')->with('success', 'تم تحديث المخزون بنجاح');
    }

    /**
     * Add stock
     */
    public function addStock(Request $request)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;

        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $stock = Stock::where('id', $request->stock_id)
            ->where('branch_id', $branchId)
            ->firstOrFail();

        $stock->update([
            'quantity' => $stock->quantity + $request->quantity
        ]);

        return redirect()->route('branch.stocks.index')->with('success', 'تم إضافة الكمية للمخزون بنجاح');
    }
}
