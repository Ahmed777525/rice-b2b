<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_ar', 'name_en', 'slug', 'description',
        'description_ar', 'description_en', 'image', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * الحصول على الاسم حسب اللغة
     */
    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * الحصول على الوصف حسب اللغة
     */
    public function getLocalizedDescriptionAttribute(): ?string
    {
        if (app()->getLocale() == 'ar') {
            return $this->description_ar ?? $this->description;
        }
        return $this->description_en ?? $this->description;
    }
}