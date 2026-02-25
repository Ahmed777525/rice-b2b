<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على الفروع
        $branches = Branch::all();
        
        // إنشاء Admin (غير مرتبط بفرع محدد)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ricecompany.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_name' => 'Rice Company HQ',
            'commercial_register' => 'CR-ADMIN-001',
            'tax_number' => 'TX-ADMIN-001',
            'phone' => '+966 50 000 0001',
            'branch_id' => null,
            'is_active' => true,
        ]);

        // إنشاء Branch Manager للفرع الأول
        if (isset($branches[0])) {
            $manager1 = User::create([
                'name' => 'Riyadh Manager',
                'email' => 'manager.riyadh@ricecompany.com',
                'password' => Hash::make('password'),
                'role' => 'branch_manager',
                'company_name' => 'Rice Company - Riyadh',
                'commercial_register' => 'CR-RUH-001',
                'tax_number' => 'TX-RUH-001',
                'phone' => '+966 50 000 0002',
                'branch_id' => $branches[0]->id,
                'is_active' => true,
            ]);
            
            // تحديث مدير الفرع في جدول branches
            $branches[0]->manager_id = $manager1->id;
            $branches[0]->save();
        }

        // إنشاء Branch Manager للفرع الثاني
        if (isset($branches[1])) {
            $manager2 = User::create([
                'name' => 'Jeddah Manager',
                'email' => 'manager.jeddah@ricecompany.com',
                'password' => Hash::make('password'),
                'role' => 'branch_manager',
                'company_name' => 'Rice Company - Jeddah',
                'commercial_register' => 'CR-JED-001',
                'tax_number' => 'TX-JED-001',
                'phone' => '+966 50 000 0003',
                'branch_id' => $branches[1]->id,
                'is_active' => true,
            ]);
            
            $branches[1]->manager_id = $manager2->id;
            $branches[1]->save();
        }

        // إنشاء تجار (Traders)
        $traders = [
            [
                'name' => 'Ahmed Al-Mansour',
                'email' => 'ahmed@trader.com',
                'company' => 'Al-Mansour Trading Est.',
                'cr' => 'CR-TRD-001',
                'tax' => 'TX-TRD-001',
                'phone' => '+966 55 111 1111',
                'branch' => 0, // Riyadh branch
            ],
            [
                'name' => 'Khalid Al-Otaibi',
                'email' => 'khalid@trader.com',
                'company' => 'Al-Otaibi Food Distribution',
                'cr' => 'CR-TRD-002',
                'tax' => 'TX-TRD-002',
                'phone' => '+966 55 222 2222',
                'branch' => 1, // Jeddah branch
            ],
            [
                'name' => 'Faisal Al-Dossari',
                'email' => 'faisal@trader.com',
                'company' => 'Al-Dossari General Trading',
                'cr' => 'CR-TRD-003',
                'tax' => 'TX-TRD-003',
                'phone' => '+966 55 333 3333',
                'branch' => 2, // Dammam branch
            ],
        ];

        foreach ($traders as $trader) {
            User::create([
                'name' => $trader['name'],
                'email' => $trader['email'],
                'password' => Hash::make('password'),
                'role' => 'trader',
                'company_name' => $trader['company'],
                'commercial_register' => $trader['cr'],
                'tax_number' => $trader['tax'],
                'phone' => $trader['phone'],
                'branch_id' => $branches[$trader['branch']]->id ?? null,
                'is_active' => true,
            ]);
        }
    }
}