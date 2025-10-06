<?php

namespace Database\Seeders;

use App\Domain\Order\Models\OrderDB;
use App\Domain\Order\Models\OrderDtDB;
use Illuminate\Database\Seeder;

class OrderDtDBSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    OrderDtDB::factory()->count(10)->create();
  }
}
