<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'make' => fake()->randomElement(['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes', 'Tesla']),
            'model' => fake()->word(),
            'year' => fake()->year(),
            'price_per_day' => fake()->randomFloat(2, 30, 300),
            'status' => fake()->randomElement(['available', 'rented', 'maintenance']),
            'image_url' => 'https://via.placeholder.com/640x480.png/0066cc?text=Car',
        ];
    }
}
