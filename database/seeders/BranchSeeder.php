<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء فرع رئيسي
        $branch = Branch::create([
            'name' => 'Main Branch - Riyadh',
            'name_ar' => 'الفرع الرئيسي - الرياض',
            'name_en' => 'Main Branch - Riyadh',
            'address' => 'King Fahd Road, Riyadh, Saudi Arabia',
            'address_ar' => 'طريق الملك فهد، الرياض، المملكة العربية السعودية',
            'address_en' => 'King Fahd Road, Riyadh, Saudi Arabia',
            'phone' => '+966 11 123 4567',
            'email' => 'riyadh@ricecompany.com',
            'is_active' => true,
        ]);

        // إنشاء فرع جدة
        $branch2 = Branch::create([
            'name' => 'Jeddah Branch',
            'name_ar' => 'فرع جدة',
            'name_en' => 'Jeddah Branch',
            'address' => 'King Abdulaziz Road, Jeddah, Saudi Arabia',
            'address_ar' => 'طريق الملك عبدالعزيز، جدة، المملكة العربية السعودية',
            'address_en' => 'King Abdulaziz Road, Jeddah, Saudi Arabia',
            'phone' => '+966 12 123 4567',
            'email' => 'jeddah@ricecompany.com',
            'is_active' => true,
        ]);

        // إنشاء فرع الدمام
        Branch::create([
            'name' => 'Dammam Branch',
            'name_ar' => 'فرع الدمام',
            'name_en' => 'Dammam Branch',
            'address' => 'King Saud Road, Dammam, Saudi Arabia',
            'address_ar' => 'طريق الملك سعود، الدمام، المملكة العربية السعودية',
            'address_en' => 'King Saud Road, Dammam, Saudi Arabia',
            'phone' => '+966 13 123 4567',
            'email' => 'dammam@ricecompany.com',
            'is_active' => true,
        ]);
    }
}