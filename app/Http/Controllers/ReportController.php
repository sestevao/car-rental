<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function paymentDetails()
    {
        $bookings = Booking::with(['user', 'car'])
            ->latest()
            ->paginate(10);

        $totalRevenue = Booking::sum('total_price');

        return Inertia::render('Reports/PaymentDetails', [
            'bookings' => $bookings,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    public function transactions()
    {
        $transactions = Booking::with(['user'])
            ->latest()
            ->paginate(15);

        return Inertia::render('Reports/Transactions', [
            'transactions' => $transactions,
        ]);
    }

    public function carReport()
    {
        $cars = Car::withCount('bookings')
            ->withSum('bookings as total_revenue', 'total_price')
            ->latest()
            ->paginate(15);

        return Inertia::render('Reports/CarReport', [
            'cars' => $cars,
        ]);
    }
}
