<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * قائمة الفروع
     */
    public function index()
    {
        $branches = Branch::with(['manager'])
            ->withCount('orders')
            ->paginate(20);
            
        return view('admin.branches.index', compact('branches'));
    }

    /**
     * عرض نموذج إنشاء فرع
     */
    public function create()
    {
        $managers = \App\Models\User::where('role', 'branch_manager')->get();
        return view('admin.branches.create', compact('managers'));
    }

    /**
     * حفظ فرع جديد
     */
    public function store(Request $request)
    {
        // Simple validation
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        // Create branch
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->name_en = $request->name_en;
        $branch->address = $request->address;
        $branch->address_en = $request->address_en;
        $branch->phone = $request->phone;
        $branch->email = $request->email;
        $branch->manager_id = $request->manager_id;
        $branch->is_active = $request->has('is_active') ? true : false;
        $branch->save();

        return redirect()->route('admin.branches.index')
            ->with('success', 'تم إنشاء الفرع بنجاح');
    }

    /**
     * عرض تفاصيل فرع
     */
    public function show($id)
    {
        $branch = Branch::with(['manager', 'orders.user'])
            ->findOrFail($id);
            
        return view('admin.branches.show', compact('branch'));
    }

    /**
     * عرض نموذج تعديل فرع
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $managers = \App\Models\User::where('role', 'branch_manager')->get();
        
        return view('admin.branches.edit', compact('branch', 'managers'));
    }

    /**
     * تحديث فرع
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        // Simple validation
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        // Update branch
        $branch->name = $request->name;
        $branch->name_en = $request->name_en;
        $branch->address = $request->address;
        $branch->address_en = $request->address_en;
        $branch->phone = $request->phone;
        $branch->email = $request->email;
        $branch->manager_id = $request->manager_id;
        $branch->is_active = $request->has('is_active') ? true : false;
        $branch->save();

        return redirect()->route('admin.branches.show', $branch->id)
            ->with('success', 'تم تحديث الفرع بنجاح');
    }

    /**
     * حذف فرع
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        
        if ($branch->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete branch with existing orders');
        }
        
        $branch->delete();
        
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully');
    }
}
