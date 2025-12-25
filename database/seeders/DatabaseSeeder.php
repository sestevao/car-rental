<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a specific test user
        $testUser = User::factory()->create([
            'name' => 'Admininstrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create random users
        $users = User::factory(10)->create();
        
        // Add test user to the collection
        $users->push($testUser);

        // Create cars
        $this->call(CarSeeder::class);
        $cars = Car::all();

        // Create drivers
        $this->call(DriverSeeder::class);

        // Create bookings
        Booking::factory(30)->make()->each(function ($booking) use ($users, $cars) {
            $booking->user_id = $users->random()->id;
            $booking->car_id = $cars->random()->id;
            $booking->save();
        });
    }
}
