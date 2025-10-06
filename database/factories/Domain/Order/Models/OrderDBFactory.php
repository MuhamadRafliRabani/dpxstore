<?php

namespace Database\Factories\Domain\Order\Models;

use App\Domain\Order\Models\OrderDB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 */
class OrderDBFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = OrderDB::class;

    public function definition(): array
    {
        $faker = $this->faker;

        return [
            "order_code" => 'ORD' . $faker->regexify('[A-Z]{2}[0-9]{6}'),
            "price" => $faker->numberBetween(10000, 500000),
            "status" => ["Pending", "Processing", "Success", "Canceled"][$faker->numberBetween(0, 3)],
            "start_process" =>    Carbon::now()->format('Y-m-d H:i:s'),
            "end_process" =>    Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s'),
            "isvoucher" => 1,
            "creby" => $faker->userName(),
            "cretime" => Carbon::now()->format('Y-m-d H:i:s'),
            "modby" => $faker->userName(),
            "modtime" => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s')
        ];
    }
}
