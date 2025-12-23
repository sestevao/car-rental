<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        // 1. Income Stats
        $incomeToday = Booking::whereDate('created_at', $today)->sum('total_price');
        $incomeYesterday = Booking::whereDate('created_at', $yesterday)->sum('total_price');
        $incomeLastWeek = Booking::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('total_price');

        // 2. Expenses Stats (Mocked)
        $expensesToday = 1500;
        $expensesYesterday = 1200;
        $expensesLastWeek = 8500;

        // 3. Hire vs Cancel (Today)
        $bookingsToday = Booking::whereDate('created_at', $today)->get();
        $totalHired = $bookingsToday->whereIn('status', ['confirmed', 'completed'])->count();
        $totalCanceled = $bookingsToday->where('status', 'cancelled')->count();
        $totalPending = $bookingsToday->where('status', 'pending')->count();

        // 4. Live Car Status
        $cars = Car::with(['bookings' => function ($query) use ($today) {
            $query->whereDate('start_date', '<=', $today)
                  ->whereDate('end_date', '>=', $today)
                  ->where('status', 'confirmed');
        }, 'bookings.user'])->latest()->take(5)->get()->map(function ($car) {
            $currentBooking = $car->bookings->first();
            return [
                'id' => $car->id,
                'car_no' => 'CAR-' . str_pad($car->id, 4, '0', STR_PAD_LEFT),
                'make_model' => $car->make . ' ' . $car->model,
                'driver' => $currentBooking ? $currentBooking->user->name : 'N/A',
                'status' => $currentBooking ? 'Hired' : ucfirst($car->status),
                'earning' => $car->bookings()->where('status', 'completed')->sum('total_price'),
                'image_url' => $car->image_url,
            ];
        });

        // 5. Earning Summary (Last 6 months)
        $earningSummary = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M');
            $year = $month->year;
            
            $currentMonthIncome = Booking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price');

            $prevYearIncome = Booking::whereYear('created_at', $year - 1)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price');

            $earningSummary[] = [
                'month' => $monthName,
                'current' => $currentMonthIncome,
                'previous' => $prevYearIncome,
            ];
        }

        return Inertia::render('Dashboard', [
            'stats' => [
                'income' => [
                    'today' => $incomeToday,
                    'yesterday' => $incomeYesterday,
                    'last_week' => $incomeLastWeek,
                ],
                'expenses' => [
                    'today' => $expensesToday,
                    'yesterday' => $expensesYesterday,
                    'last_week' => $expensesLastWeek,
                ],
                'bookings_today' => [
                    'hired' => $totalHired,
                    'canceled' => $totalCanceled,
                    'pending' => $totalPending,
                ],
            ],
            'cars' => $cars,
            'earningSummary' => $earningSummary,
        ]);
    }
}
