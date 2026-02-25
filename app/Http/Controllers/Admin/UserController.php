<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * قائمة المستخدمين
     */
    public function index(Request $request)
    {
        $query = User::with(['branch']);

        // البحث
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }

        // فلترة حسب الدور
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // فلترة حسب الفرع
        if ($request->has('branch_id') && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        // فلترة حسب التفعيل
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $users = $query->latest()->paginate(20);
        $branches = Branch::all();

        return view('admin.users.index', compact('users', 'branches'));
    }

    /**
     * إضافة مستخدم جديد
     */
    public function create()
    {
        $branches = Branch::all();
        return view('admin.users.create', compact('branches'));
    }

    /**
     * حفظ مستخدم جديد
     */
    public function store(Request $request)
    {
        // Simple validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        // Create user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->branch_id = $request->branch_id;
        $user->company_name = $request->company_name;
        $user->commercial_register = $request->commercial_register;
        $user->is_active = $request->has('is_active') ? true : true;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    /**
     * عرض تفاصيل المستخدم
     */
    public function show($id)
    {
        $user = User::with(['branch', 'orders'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * تعديل المستخدم
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $branches = Branch::all();
        return view('admin.users.edit', compact('user', 'branches'));
    }

    /**
     * تحديث المستخدم
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Simple validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
        ]);

        // Update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->branch_id = $request->branch_id;
        $user->company_name = $request->company_name;
        $user->commercial_register = $request->commercial_register;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    /**
     * تفعيل/تعطيل المستخدم
     */
    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'تم تفعيل' : 'تم تعطيل';
        return back()->with('success', "{$status} المستخدم بنجاح");
    }

    /**
     * حذف المستخدم
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // لا يمكن حذف المدير العام
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'لا يمكن حذف آخر مدير في النظام');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
