<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarDetail;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2024,
                'price_per_day' => 45.00,
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1621007947382-bb3c3968e3bb?auto=format&fit=crop&w=800&q=80',
                'details' => [
                    'transmission' => 'Automatic',
                    'seats' => '5',
                    'fuel_type' => 'Petrol',
                    'large_bags' => '2',
                    'small_bags' => '1',
                    'mileage_policy' => 'Unlimited',
                    'location' => 'London Heathrow',
                    'cancellation_policy' => 'Free cancellation up to 24h',
                ]
            ],
            [
                'make' => 'BMW',
                'model' => '3 Series',
                'year' => 2023,
                'price_per_day' => 85.00,
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1555215695-3004980adade?auto=format&fit=crop&w=800&q=80',
                'details' => [
                    'transmission' => 'Automatic',
                    'seats' => '5',
                    'fuel_type' => 'Diesel',
                    'large_bags' => '2',
                    'small_bags' => '2',
                    'mileage_policy' => 'Unlimited',
                    'location' => 'Manchester Airport',
                    'cancellation_policy' => 'Free cancellation up to 48h',
                ]
            ],
            [
                'make' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2024,
                'price_per_day' => 95.00,
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800&q=80',
                'details' => [
                    'transmission' => 'Automatic',
                    'seats' => '5',
                    'fuel_type' => 'Electric',
                    'large_bags' => '2',
                    'small_bags' => '1',
                    'mileage_policy' => '300 miles/day',
                    'location' => 'Central London',
                    'cancellation_policy' => 'Free cancellation up to 24h',
                ]
            ],
            [
                'make' => 'Ford',
                'model' => 'Mustang',
                'year' => 2023,
                'price_per_day' => 120.00,
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=800&q=80',
                'details' => [
                    'transmission' => 'Automatic',
                    'seats' => '4',
                    'fuel_type' => 'Petrol',
                    'large_bags' => '1',
                    'small_bags' => '1',
                    'mileage_policy' => 'Unlimited',
                    'location' => 'Gatwick Airport',
                    'cancellation_policy' => 'Non-refundable',
                ]
            ],
            [
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'year' => 2024,
                'price_per_day' => 90.00,
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=800&q=80',
                'details' => [
                    'transmission' => 'Automatic',
                    'seats' => '5',
                    'fuel_type' => 'Diesel',
                    'large_bags' => '2',
                    'small_bags' => '2',
                    'mileage_policy' => 'Unlimited',
                    'location' => 'Birmingham Airport',
                    'cancellation_policy' => 'Free cancellation up to 48h',
                ]
            ],
            [
                'make' => 'Land Rover',
                'model' => 'Range Rover Evoque',
                'year' => 2023,
                'price_per_day' => 110.00,
                'status' => 'available',
                'image_url' => 'https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&w=800&q=80',
                'details' => [
                    'transmission' => 'Automatic',
                    'seats' => '5',
                    'fuel_type' => 'Diesel',
                    'large_bags' => '4',
                    'small_bags' => '2',
                    'mileage_policy' => 'Unlimited',
                    'location' => 'Edinburgh Airport',
                    'cancellation_policy' => 'Free cancellation up to 24h',
                ]
            ],
        ];

        foreach ($cars as $carData) {
            $details = $carData['details'];
            unset($carData['details']);

            $car = Car::create($carData);

            foreach ($details as $key => $value) {
                $car->details()->create([
                    'name' => $key,
                    'value' => $value,
                ]);
            }
        }
    }
}
