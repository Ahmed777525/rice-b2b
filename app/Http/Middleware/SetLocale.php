<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // التحقق من وجود لغة في الجلسة
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            
            // التأكد من أن اللغة مدعومة
            if (in_array($locale, ['en', 'ar'])) {
                App::setLocale($locale);
            }
        }
        
        return $next($request);
    }
}