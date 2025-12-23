<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        // Mock notifications for now
        $notifications = [
            [
                'id' => 1,
                'type' => 'booking_confirmed',
                'title' => 'Booking Confirmed',
                'message' => 'Your booking for Toyota Camry has been confirmed.',
                'created_at' => Carbon::now()->subHours(2)->toDateTimeString(),
                'read_at' => null,
            ],
            [
                'id' => 2,
                'type' => 'payment_received',
                'title' => 'Payment Received',
                'message' => 'Payment of $150.00 was successfully processed.',
                'created_at' => Carbon::yesterday()->toDateTimeString(),
                'read_at' => Carbon::yesterday()->addHours(1)->toDateTimeString(),
            ],
            [
                'id' => 3,
                'type' => 'maintenance_alert',
                'title' => 'Maintenance Alert',
                'message' => 'Car BMW X5 requires scheduled maintenance.',
                'created_at' => Carbon::now()->subDays(2)->toDateTimeString(),
                'read_at' => null,
            ],
            [
                'id' => 4,
                'type' => 'system_update',
                'title' => 'System Update',
                'message' => 'The system will undergo maintenance tonight at 2 AM.',
                'created_at' => Carbon::now()->subDays(5)->toDateTimeString(),
                'read_at' => Carbon::now()->subDays(5)->addHours(2)->toDateTimeString(),
            ],
        ];

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }
}
