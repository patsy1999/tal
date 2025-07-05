<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockUsage;
use Carbon\Carbon;

class StockUsageSeeder extends Seeder
{
    public function run()
    {
        StockUsage::truncate();

        $startDate = Carbon::create(2025, 3, 3);
        $endDate = Carbon::now(); // today's date dynamically
        $totalDays = $startDate->diffInDays($endDate) + 1;

        $start = 168;
        $end = 20;
        $step = 2;
        $cycleLength = intval((($start - $end) / $step) + 1);

        for ($i = 0; $i < $totalDays; $i++) {
            $position = $i % $cycleLength;
            $stockQuantity = $start - ($position * $step);

            StockUsage::create([
                'date' => $startDate->copy()->addDays($i),
                'used_quantity' => 2,
                'stock_quantity' => $stockQuantity,
            ]);
        }
    }
}
