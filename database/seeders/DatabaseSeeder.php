<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class, // هذا السيدر يعتمد على الفروع والتصنيفات
        ]);
    }
}