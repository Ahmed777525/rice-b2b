<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login-new');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // توجيه المستخدم بناءً على دوره
        $user = $request->user();
        
        if ($user->isBranchManager()) {
            // مدير الفرع يذهب للوحة تحكم الفرع
            return redirect('/branch/dashboard');
        } elseif ($user->isAdmin()) {
            // المدير العام يذهب للوحة تحكم الإدارة
            return redirect('/admin/dashboard');
        } else {
            // التاجر يذهب للوحة التحكم العادية
            return redirect('/dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
