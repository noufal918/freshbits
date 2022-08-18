<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->name,
            'price' => $this->faker->randomNumber,
            'upc' => $this->faker->unique()->name,
            'image' => $this->faker->image('public/storage/uploads/products/image/',400,300)
        ];
    }
}
