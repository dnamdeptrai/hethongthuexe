<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->company().' '.fake()->randomNumber(3),
            'brand' => fake()->randomElement(['Toyota', 'Ford', 'Honda', 'VinFast']),
            'image' => null,
            'transmission' => fake()->randomElement(['Automatic', 'Manual']),
            'fuel_type' => fake()->randomElement(['Gasoline', 'Electric']),
            'seats' => fake()->randomElement([4, 7, 16]),
            'price_per_day' => 500000,
            'status' => 'available',
        ];
    }
}
