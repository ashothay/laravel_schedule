<?php

use App\Period;
use Illuminate\Database\Seeder;

class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($starts_at = 28800; $starts_at < 56000; $starts_at += 3600) {
            Period::create([
                'starts_at' => date('H:i', $starts_at),
                'ends_at' => date('H:i', $starts_at + 2700),
            ]);
        }
    }
}
