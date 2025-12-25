<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        // Fetch featured cars (e.g., latest 3 available cars)
        $featuredCars = Car::where('status', 'available')
            ->with('details')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($car) {
                // Transform details to be easily accessible
                $details = $car->details->pluck('value', 'name')->toArray();
                $car->features = $details;
                return $car;
            });

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'featuredCars' => $featuredCars,
        ]);
    }

    public function cars(Request $request)
    {
        $query = Car::where('status', 'available');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $cars = $query->latest()->with('details')->paginate(9)->withQueryString();
        
        $cars->getCollection()->transform(function ($car) {
             $details = $car->details->pluck('value', 'name')->toArray();
             $car->features = $details;
             return $car;
        });

        return Inertia::render('Frontend/Cars/Index', [
            'cars' => $cars,
            'filters' => $request->only(['search']),
        ]);
    }

    public function show(Car $car)
    {
        // Load details if relationship exists
        $car->load('details');
        
        // Transform details to be easily accessible
        $details = $car->details->pluck('value', 'name')->toArray();
        $car->features = $details;

        return Inertia::render('Frontend/Cars/Show', [
            'car' => $car,
        ]);
    }

    public function myBookings()
    {
        $bookings = Booking::with('car')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return Inertia::render('Frontend/Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }
}
