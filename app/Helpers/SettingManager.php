<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class SettingManager
{
    private $settings = [];
    private $cacheKey = 'app_settings';

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * تحميل الإعدادات من الكاش
     */
    private function loadSettings()
    {
        $this->settings = Cache::get($this->cacheKey, []);
    }

    /**
     * الحصول على قيمة إعداد
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * تعيين قيمة إعداد
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        return $this;
    }

    /**
     * حفظ الإعدادات في الكاش
     * 
     * @return bool
     */
    public function save()
    {
        Cache::forever($this->cacheKey, $this->settings);
        return true;
    }

    /**
     * الحصول على جميع الإعدادات
     * 
     * @return array
     */
    public function all()
    {
        return $this->settings;
    }

    /**
     * مسح إعدادات محددة
     * 
     * @param string $key
     * @return bool
     */
    public function forget($key)
    {
        unset($this->settings[$key]);
        return $this->save();
    }

    /**
     * مسح جميع الإعدادات
     * 
     * @return bool
     */
    public function flush()
    {
        $this->settings = [];
        return $this->save();
    }
}
