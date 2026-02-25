<?php

use Illuminate\Support\Facades\Cache;

/**
 * دالة مساعدة للوصول لإعدادات التطبيق
 * 
 * @return \App\Helpers\SettingManager
 */
if (!function_exists('setting')) {
    function setting()
    {
        return new \App\Helpers\SettingManager();
    }
}
