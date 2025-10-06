<?php

namespace Database\Seeders;

use App\Domain\Order\Models\OrderDB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderDB::factory()->count(10)->create();
    }
}
