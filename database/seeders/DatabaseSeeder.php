<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call your AdminUserSeeder and any others here
        $this->call([
            AdminUserSeeder::class,
            EquipmentListSeeder::class,
            InstrumentSeeder::class,
            StockUsageSeeder::class,
            // Add other seeders if you want
        ]);
    }
}
