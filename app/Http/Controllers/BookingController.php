<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Notifications\BookingStatusUpdated;

use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['car', 'user'])->latest();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('car', function ($query) use ($search) {
                    $query->where('make', 'like', "%{$search}%")
                          ->orWhere('model', 'like', "%{$search}%");
                });
            });
        }

        if ($request->has('status') && $request->input('status') !== '') {
            $query->where('status', $request->input('status'));
        }

        $bookings = $query->paginate(10)->withQueryString();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = \App\Models\Car::findOrFail($validated['car_id']);
        
        // Simple availability check (overlapping bookings)
        $exists = Booking::where('car_id', $car->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                      });
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['start_date' => 'This car is already booked for the selected dates.']);
        }

        $days = (strtotime($validated['end_date']) - strtotime($validated['start_date'])) / (60 * 60 * 24);
        // Ensure at least 1 day charged if start != end (which is enforced by after:start_date, so at least 1 day diff roughly, but strictly it could be same day if time involved? usually date inputs are Y-m-d so min 1 day)
        $days = max(1, $days); 
        
        $total_price = $days * $car->price_per_day;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'pending',
            'total_price' => $total_price,
        ]);

        return redirect()->route('payment.create', $booking)->with('success', 'Booking created! Please complete payment.');
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
    public function edit(Booking $booking)
    {
        return Inertia::render('Bookings/Edit', [
            'booking' => $booking->load(['user', 'car', 'transaction']),
            'cars' => \App\Models\Car::where('status', 'available')->orWhere('id', $booking->car_id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $car = \App\Models\Car::find($validated['car_id']);
        $days = (strtotime($validated['end_date']) - strtotime($validated['start_date'])) / (60 * 60 * 24);
        $total_price = $days * $car->price_per_day;

        $booking->update([
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'total_price' => $total_price,
        ]);

        if ($booking->wasChanged('status')) {
            $booking->user->notify(new BookingStatusUpdated($booking));
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
