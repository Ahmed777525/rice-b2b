<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        foreach ($roles as $role) {
            // معالجة تمرير الأدوار إما كمصفوفة أو كـ string مفصول بـ |
            $roleArray = explode('|', $role);
            foreach ($roleArray as $r) {
                if ($user->role === $r) {
                    return $next($request);
                }
            }
        }

        // إذا لم يملك الصلاحية، نعيده للصفحة الرئيسية مع رسالة خطأ
        abort(403, 'Unauthorized access.');
    }
}