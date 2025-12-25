<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'license_number' => fake()->bothify('??######'),
            'status' => fake()->randomElement(['available', 'busy', 'inactive']),
            'image_url' => 'https://i.pravatar.cc/150?u=' . fake()->uuid(),
        ];
    }
}
