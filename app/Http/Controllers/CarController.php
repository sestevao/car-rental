<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::latest()->paginate(20);
        return Inertia::render('Cars/Index', [
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cars/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            // Details
            'seats' => 'nullable|integer|min:1',
            'transmission' => 'nullable|string|max:255',
            'large_bags' => 'nullable|integer|min:0',
            'small_bags' => 'nullable|integer|min:0',
            'mileage_policy' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'pickup_type' => 'nullable|string|max:255',
            'cancellation_policy' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $car = Car::create($validated);

        $detailKeys = [
            'seats', 'transmission', 'large_bags', 'small_bags', 
            'mileage_policy', 'location', 'pickup_type', 'cancellation_policy'
        ];

        foreach ($detailKeys as $key) {
            if (isset($validated[$key])) {
                $car->details()->create([
                    'name' => $key,
                    'value' => $validated[$key]
                ]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $car->load(['bookings' => function ($query) {
            $query->latest();
        }, 'bookings.user', 'details']);

        // Transform details into properties for easier frontend access
        foreach ($car->details as $detail) {
            $car->setAttribute($detail->name, $detail->value);
        }

        return Inertia::render('Cars/Edit', [
            'car' => $car,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'seats' => 'nullable|integer|min:1',
            'transmission' => 'nullable|string|max:255',
            'large_bags' => 'nullable|integer|min:0',
            'small_bags' => 'nullable|integer|min:0',
            'mileage_policy' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'pickup_type' => 'nullable|string|max:255',
            'cancellation_policy' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cars', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $car->update($validated);

        $detailKeys = [
            'seats', 'transmission', 'large_bags', 'small_bags', 
            'mileage_policy', 'location', 'pickup_type', 'cancellation_policy'
        ];

        foreach ($detailKeys as $key) {
            if (array_key_exists($key, $validated)) {
                if ($validated[$key] !== null) {
                    $car->details()->updateOrCreate(
                        ['name' => $key],
                        ['value' => $validated[$key]]
                    );
                } else {
                    $car->details()->where('name', $key)->delete();
                }
            }
        }

        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
    }
}
