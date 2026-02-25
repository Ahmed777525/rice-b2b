<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * تغيير اللغة
     */
    public function switch($locale)
    {
        // التحقق من أن اللغة مدعومة
        if (!in_array($locale, ['en', 'ar'])) {
            abort(400);
        }
        
        // حفظ اللغة في الجلسة
        Session::put('locale', $locale);
        
        // إعادة التوجيه إلى الصفحة السابقة
        return redirect()->back();
    }
}