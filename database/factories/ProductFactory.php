<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => strtoupper(Str::random(10)),
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(100, 500),
            'created_at' => date("Y-m-d H:i:s")
        ];
    }
}
