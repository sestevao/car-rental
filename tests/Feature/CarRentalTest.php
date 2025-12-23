<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarRentalTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_stats()
    {
        $user = User::factory()->create();
        
        Car::factory()->create(['status' => 'available']);
        Car::factory()->create(['status' => 'rented']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->has('totalCars')
            ->has('availableCars')
        );
    }

    public function test_cars_page_displays_cars()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->actingAs($user)->get('/cars');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Cars/Index')
            ->has('cars', 1)
        );
    }

    public function test_can_create_car()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/cars', [
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2022,
            'price_per_day' => 50,
            'status' => 'available',
        ]);

        $response->assertRedirect('/cars');
        $this->assertDatabaseHas('cars', [
            'make' => 'Toyota',
            'model' => 'Camry',
        ]);
    }
}
