<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'address',
        'address_ar',
        'address_en',
        'phone',
        'email',
        'manager_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدمين (الموظفين في هذا الفرع)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * العلاقة مع مدير الفرع
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * العلاقة مع المخزون
     */
    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * العلاقة مع الطلبات
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * الحصول على الاسم حسب اللغة
     */
    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() == 'ar' ? ($this->name_ar ?? $this->name) : ($this->name_en ?? $this->name);
    }

    /**
     * الحصول على العنوان حسب اللغة
     */
    public function getLocalizedAddressAttribute(): string
    {
        return app()->getLocale() == 'ar' ? ($this->address_ar ?? $this->address) : ($this->address_en ?? $this->address);
    }
}