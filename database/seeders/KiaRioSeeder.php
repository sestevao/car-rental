<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarDetail;
use Illuminate\Database\Seeder;

class KiaRioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $car = Car::create([
            'make' => 'Kia',
            'model' => 'Rio',
            'year' => 2024,
            'price_per_day' => 17.67, // £53 for 3 days
            'status' => 'available',
            'image_url' => 'https://example.com/kia-rio.jpg', // Placeholder
        ]);

        $details = [
            'seats' => '5',
            'transmission' => 'Manual',
            'large_bags' => '1',
            'small_bags' => '1',
            'mileage_policy' => '300 miles per rental',
            'location' => 'London Heathrow Airport',
            'pickup_type' => 'Shuttle Bus',
            'cancellation_policy' => 'Free cancellation',
        ];

        foreach ($details as $name => $value) {
            CarDetail::create([
                'car_id' => $car->id,
                'name' => $name,
                'value' => $value,
            ]);
        }
    }
}
