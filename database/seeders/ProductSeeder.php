<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Branch;
use App\Models\ProductPrice;
use App\Models\Stock;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $branches = Branch::all();

        $products = [
            // بسمتي
            [
                'category' => 'بسمتي',
                'items' => [
                    [
                        'name' => 'بسمتي هندي 5 كيلو',
                        'name_ar' => 'بسمتي هندي 5 كيلو',
                        'name_en' => 'Indian Basmati 5kg',
                        'sku' => 'BAS-5KG-001',
                        'description' => 'أرز بسمتي هندي فاخر - 5 كيلو',
                        'unit' => 'kg',
                        'unit_weight' => 5,
                        'min_order' => 5,
                        'prices' => [
                            'price' => 120.00,
                            'cost' => 90.00,
                            'wholesale' => 110.00,
                            'wholesale_min' => 50,
                        ]
                    ],
                    [
                        'name' => 'بسمتي هندي 10 كيلو',
                        'name_ar' => 'بسمتي هندي 10 كيلو',
                        'name_en' => 'Indian Basmati 10kg',
                        'sku' => 'BAS-10KG-001',
                        'description' => 'أرز بسمتي هندي فاخر - 10 كيلو',
                        'unit' => 'kg',
                        'unit_weight' => 10,
                        'min_order' => 5,
                        'prices' => [
                            'price' => 220.00,
                            'cost' => 165.00,
                            'wholesale' => 200.00,
                            'wholesale_min' => 30,
                        ]
                    ],
                ]
            ],
            // عنبر
            [
                'category' => 'عنبر',
                'items' => [
                    [
                        'name' => 'عنبر سعودي 5 كيلو',
                        'name_ar' => 'عنبر سعودي 5 كيلو',
                        'name_en' => 'Saudi Anbar 5kg',
                        'sku' => 'ANB-5KG-001',
                        'description' => 'أرز عنبر سعودي فاخر - 5 كيلو',
                        'unit' => 'kg',
                        'unit_weight' => 5,
                        'min_order' => 5,
                        'prices' => [
                            'price' => 180.00,
                            'cost' => 135.00,
                            'wholesale' => 165.00,
                            'wholesale_min' => 40,
                        ]
                    ],
                    [
                        'name' => 'عنبر سعودي 10 كيلو',
                        'name_ar' => 'عنبر سعودي 10 كيلو',
                        'name_en' => 'Saudi Anbar 10kg',
                        'sku' => 'ANB-10KG-001',
                        'description' => 'أرز عنبر سعودي فاخر - 10 كيلو',
                        'unit' => 'kg',
                        'unit_weight' => 10,
                        'min_order' => 5,
                        'prices' => [
                            'price' => 320.00,
                            'cost' => 240.00,
                            'wholesale' => 295.00,
                            'wholesale_min' => 25,
                        ]
                    ],
                ]
            ],
            // مصري
            [
                'category' => 'مصري',
                'items' => [
                    [
                        'name' => 'أرز مصري 5 كيلو',
                        'name_ar' => 'أرز مصري 5 كيلو',
                        'name_en' => 'Egyptian Rice 5kg',
                        'sku' => 'EGY-5KG-001',
                        'description' => 'أرز مصري عالي الجودة - 5 كيلو',
                        'unit' => 'kg',
                        'unit_weight' => 5,
                        'min_order' => 10,
                        'prices' => [
                            'price' => 75.00,
                            'cost' => 55.00,
                            'wholesale' => 68.00,
                            'wholesale_min' => 100,
                        ]
                    ],
                ]
            ],
        ];

        foreach ($products as $productGroup) {
            $category = $categories->where('name_ar', $productGroup['category'])->first();
            
            if (!$category) continue;

            foreach ($productGroup['items'] as $item) {
                // إنشاء المنتج
                $product = Product::create([
                    'name' => $item['name'],
                    'name_ar' => $item['name_ar'],
                    'name_en' => $item['name_en'],
                    'slug' => Str::slug($item['name_en']),
                    'sku' => $item['sku'],
                    'description' => $item['description'],
                    'description_ar' => $item['description'],
                    'description_en' => $item['description'],
                    'category_id' => $category->id,
                    'unit' => $item['unit'],
                    'unit_weight' => $item['unit_weight'],
                    'min_order_quantity' => $item['min_order'],
                    'is_active' => true,
                    'is_featured' => true,
                    'tax_rate' => 15.00,
                ]);

                // إضافة الأسعار والمخزون لكل فرع
                foreach ($branches as $index => $branch) {
                    // اختلاف بسيط في الأسعار بين الفروع
                    $priceMultiplier = 1.0;
                    if ($branch->name_en == 'Jeddah Branch') {
                        $priceMultiplier = 1.05; // 5% زيادة في جدة
                    } elseif ($branch->name_en == 'Dammam Branch') {
                        $priceMultiplier = 0.98; // 2% خصم في الدمام
                    }

                    // سعر المنتج للفرع
                    ProductPrice::create([
                        'product_id' => $product->id,
                        'branch_id' => $branch->id,
                        'price' => $item['prices']['price'] * $priceMultiplier,
                        'cost' => $item['prices']['cost'] * $priceMultiplier,
                        'wholesale_price' => $item['prices']['wholesale'] * $priceMultiplier,
                        'wholesale_min_quantity' => $item['prices']['wholesale_min'],
                        'is_active' => true,
                    ]);

                    // مخزون مختلف لكل فرع
                    $stockQuantity = rand(500, 2000); // كمية عشوائية بين 500 و 2000
                    Stock::create([
                        'product_id' => $product->id,
                        'branch_id' => $branch->id,
                        'quantity' => $stockQuantity,
                        'reserved_quantity' => 0,
                        'reorder_level' => 100,
                        'max_stock_level' => 5000,
                        'location_in_warehouse' => "Aisle " . chr(65 + $index) . ", Shelf " . rand(1, 10),
                    ]);
                }
            }
        }
    }
}