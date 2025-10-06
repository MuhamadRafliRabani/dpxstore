<?php

namespace Database\Factories\Domain\Product\Models;

use App\Domain\Product\Models\Product_dt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 */
class product_dtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product_dt::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
            "product_name" => $faker->words(3, true),
            "category" => "Games",
            "brand" =>    "Mobile Legends",
            "type" => "Umum",
            "seller_name" => "PT. ABC",
            "price" => $faker->numberBetween(10000, 500000),
            "buyer_sku_code" => $faker->regexify('[A-Z]{1}[0-9]{3}'),
            "buyer_product_status" => true,
            "seller_product_status" => true,
            "unlimited_stock" => true,
            "stock" => 0,
            "multi" => true,
            "start_cut_off" => date('H:i', time()),
            "end_cut_off" => date('H:i', time() + 60 * 60 * 24 * 7),
            "desc" => $faker->text(50),
            "creby" => $faker->userName(),
            "cretime" => now(),
            "modby" => $faker->userName(),
            "modtime" => now()
        ];
    }
}
