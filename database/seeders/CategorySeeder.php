<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'بسمتي',
                'name_ar' => 'بسمتي',
                'name_en' => 'Basmati',
                'description' => 'أرز بسمتي عالي الجودة من جبال الهيمالايا',
                'description_ar' => 'أرز بسمتي عالي الجودة من جبال الهيمالايا',
                'description_en' => 'High-quality Basmati rice from the Himalayas',
                'sort_order' => 1,
            ],
            [
                'name' => 'عنبر',
                'name_ar' => 'عنبر',
                'name_en' => 'Anbar',
                'description' => 'أرز عنبر السعودي الفاخر',
                'description_ar' => 'أرز عنبر السعودي الفاخر',
                'description_en' => 'Premium Saudi Anbar rice',
                'sort_order' => 2,
            ],
            [
                'name' => 'مصري',
                'name_ar' => 'مصري',
                'name_en' => 'Egyptian',
                'description' => 'أرز مصري عالي الجودة',
                'description_ar' => 'أرز مصري عالي الجودة',
                'description_en' => 'High-quality Egyptian rice',
                'sort_order' => 3,
            ],
            [
                'name' => 'أمريكي',
                'name_ar' => 'أمريكي',
                'name_en' => 'American',
                'description' => 'أرز أمريكي طويل الحبة',
                'description_ar' => 'أرز أمريكي طويل الحبة',
                'description_en' => 'American long-grain rice',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'name_ar' => $category['name_ar'],
                'name_en' => $category['name_en'],
                'slug' => Str::slug($category['name_en']),
                'description' => $category['description'],
                'description_ar' => $category['description_ar'],
                'description_en' => $category['description_en'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}