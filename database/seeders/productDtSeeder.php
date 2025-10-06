<?php

namespace Database\Seeders;

use App\Domain\Product\Models\Product_dt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class productDtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product_dt::factory()->count(10)->create();
    }
}
