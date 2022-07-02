<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'amount' => $this->faker->numberBetween(0, 10),
            'price' => $this->faker->numberBetween(5000, 10000),
            'new_price' => $this->newPrice(),
        ];
    }

    public function newPrice()
    {
        $this->faker->randomElement([
            $this->faker->numberBetween(0, 5000),
            null
        ]);
    }
}
