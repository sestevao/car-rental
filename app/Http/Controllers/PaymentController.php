<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Notifications\BookingCreated;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        // Ensure user owns the booking and it's pending
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
             return redirect()->route('my-bookings');
        }

        $booking->load('car');

        return Inertia::render('Payment/Create', [
            'booking' => $booking,
        ]);
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Validation for fake payment details
        $request->validate([
            'card_number' => 'required|string|min:16', 
            'expiry_date' => 'required|string',
            'cvv' => 'required|string|min:3',
            'card_holder' => 'required|string',
        ]);

        // Create Transaction
        Transaction::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'amount' => $booking->total_price,
            'payment_method' => 'credit_card',
            'transaction_id' => 'TXN-' . Str::upper(Str::random(10)),
            'status' => 'success',
        ]);

        // Update Booking
        $booking->update(['status' => 'confirmed']);

        // Send Notification
        $booking->user->notify(new BookingCreated($booking));

        // Notify Admin
        $admin = \App\Models\User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->notify(new BookingCreated($booking));
        }

        return redirect()->route('my-bookings')->with('success', 'Payment successful! Your booking is confirmed.');
    }
}
