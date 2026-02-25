<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * صفحة الإعدادات
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * إعدادات عامة
     */
    public function general(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'app_name' => 'required|string|max:255',
                'app_description' => 'nullable|string',
                'contact_email' => 'nullable|email',
                'contact_phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            // حفظ في config أو cache
            foreach ($request->except('_token') as $key => $value) {
                setting()->set($key, $value);
            }
            setting()->save();

            return back()->with('success', 'تم حفظ الإعدادات العامة');
        }

        return view('admin.settings.general');
    }

    /**
     * إعدادات الفروع
     */
    public function branches(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'default_branch_id' => 'required|exists:branches,id',
            ]);

            setting()->set('default_branch_id', $request->default_branch_id);
            setting()->save();

            return back()->with('success', 'تم حفظ إعدادات الفروع');
        }

        $branches = Branch::all();
        return view('admin.settings.branches', compact('branches'));
    }

    /**
     * إعدادات المخزون
     */
    public function stock(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'low_stock_threshold' => 'required|integer|min:1',
                'auto_reject_out_of_stock' => 'boolean',
                'allow_negative_stock' => 'boolean',
            ]);

            foreach ($request->except('_token') as $key => $value) {
                setting()->set($key, $value === 'on' ? true : $request->$key);
            }
            setting()->save();

            return back()->with('success', 'تم حفظ إعدادات المخزون');
        }

        return view('admin.settings.stock');
    }

    /**
     * إعدادات الطلبات
     */
    public function orders(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'order_prefix' => 'required|string|max:10',
                'auto_approve_minimum_order' => 'nullable|integer|min:0',
            ]);

            foreach ($request->except('_token') as $key => $value) {
                setting()->set($key, $value);
            }
            setting()->save();

            return back()->with('success', 'تم حفظ إعدادات الطلبات');
        }

        return view('admin.settings.orders');
    }

    /**
     * إعدادات الدفع
     */
    public function payment(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'payment_methods' => 'required|array',
                'visa_enabled' => 'boolean',
                'mada_enabled' => 'boolean',
                'paypal_enabled' => 'boolean',
            ]);

            setting()->set('visa_enabled', $request->has('visa_enabled'));
            setting()->set('mada_enabled', $request->has('mada_enabled'));
            setting()->set('paypal_enabled', $request->has('paypal_enabled'));
            
            if ($request->has('sandbox_mode')) {
                setting()->set('sandbox_mode', true);
            } else {
                setting()->set('sandbox_mode', false);
            }

            setting()->save();

            return back()->with('success', 'تم حفظ إعدادات الدفع');
        }

        return view('admin.settings.payment');
    }

    /**
     * إعدادات البريد
     */
    public function mail(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'mail_driver' => 'required|in:smtp,mailgun,sendmail',
                'mail_host' => 'required_if:mail_driver,smtp',
                'mail_port' => 'required_if:mail_driver,smtp',
                'mail_username' => 'nullable|string',
                'mail_password' => 'nullable|string',
                'mail_from_address' => 'nullable|email',
            ]);

            foreach ($request->except('_token', 'mail_password') as $key => $value) {
                setting()->set($key, $value);
            }
            
            if ($request->mail_password) {
                setting()->set('mail_password', $request->mail_password);
            }
            
            setting()->save();

            return back()->with('success', 'تم حفظ إعدادات البريد');
        }

        return view('admin.settings.mail');
    }

    /**
     * مسح الكاش
     */
    public function clearCache()
    {
        Cache::flush();
        Artisan::call('optimize:clear');
        
        return back()->with('success', 'تم مسح الكاش بنجاح');
    }
}

// Helper function for settings
if (!function_exists('setting')) {
    function setting() {
        return new class {
            private $settings = [];
            
            public function __construct() {
                // Load from cache or database
                $this->settings = Cache::get('app_settings', []);
            }
            
            public function set($key, $value) {
                $this->settings[$key] = $value;
            }
            
            public function get($key, $default = null) {
                return $this->settings[$key] ?? $default;
            }
            
            public function save() {
                Cache::forever('app_settings', $this->settings);
            }
        };
    }
}
