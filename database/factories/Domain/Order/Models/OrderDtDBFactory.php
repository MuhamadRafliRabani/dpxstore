<?php

namespace Database\Factories\Domain\Order\Models;

use App\Domain\Order\Models\OrderDB;
use App\Domain\Order\Models\OrderDtDB;
use App\Domain\Product\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 */
class OrderDtDBFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */

  protected $model = OrderDtDB::class;

  public function definition(): array
  {
    $faker = $this->faker;

    $order = OrderDB::pluck('id')->toArray();
    $product = Product::pluck('id')->toArray();

    $category = [1, 2, 3, 4][$faker->numberBetween(0, 3)];

    $user_id = null;
    $zone_id = null;
    $username = null;
    $no_handphone = null;
    $no_akun = null;

    switch ($category) {
      case 1: // Game
        $user_id = $faker->regexify('[0-9]{6}');
        $zone_id = $faker->regexify('[0-9]{4}');
        $username = $faker->userName();
        break;

      case 2: // Pulsa
        $no_handphone = '08' . $faker->regexify('[0-9]{10}');
        break;

      case 4: // Akun tertentu
        $no_akun = $faker->regexify('[0-9]{10}');
        break;
    }

    return [
      "order_id" => $faker->randomElement($order),
      "category_id" => $category,
      "product_id" => $faker->randomElement($product),
      "voucher_id" => 1,
      "user_id" => $user_id,
      "zone_id" => $zone_id,
      "username" => $username,
      "no_handphone" => $no_handphone,
      "no_akun" => $no_akun,
      "whatsapp" => '08' . $faker->regexify('[0-9]{10}'),
      "creby" => $faker->userName(),
      "cretime" => Carbon::now(),
      "modby" => $faker->userName(),
      "modtime" => Carbon::now()->addMinutes(15)
    ];
  }
}
