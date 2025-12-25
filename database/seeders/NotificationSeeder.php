<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Booking;
use App\Notifications\BookingCreated;
use App\Notifications\BookingStatusUpdated;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $bookings = Booking::with(['user', 'car'])->get();

        // 1. Generate notifications for Admin
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            // Notify admin about random recent bookings (Payment Received)
            $recentBookings = $bookings->random(min(5, $bookings->count()));
            foreach ($recentBookings as $booking) {
                // Manually trigger the notification logic for Admin inside BookingCreated
                // Or simply notify the admin with existing notification class which handles admin check
                $admin->notify(new BookingCreated($booking));
            }
        }

        // 2. Generate notifications for Users
        foreach ($users as $user) {
            // Skip if user has no bookings, or just pick random bookings to notify about
            $userBookings = $bookings->where('user_id', $user->id);
            
            if ($userBookings->count() > 0) {
                foreach ($userBookings as $booking) {
                    // Randomly decide to send a notification
                    if (rand(0, 1)) {
                        // Either booking confirmation or status update
                        if (rand(0, 1)) {
                             $user->notify(new BookingCreated($booking));
                        } else {
                            // Randomly change status for the notification context (not saving to DB to avoid messing up data state too much, or actually update it?)
                            // Ideally, we just want to create the notification record.
                            // The notification class uses the current state of the booking.
                            // So let's just send a notification based on current status.
                             $user->notify(new BookingStatusUpdated($booking));
                        }
                    }
                }
            }
        }
    }
}
