<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = ucfirst($this->booking->status);
        $type = 'system_update'; // Default

        if ($this->booking->status === 'confirmed') {
            $type = 'booking_confirmed';
        } elseif ($this->booking->status === 'cancelled') {
            $type = 'maintenance_alert'; // Use yellow/alert icon
        } elseif ($this->booking->status === 'completed') {
            $type = 'payment_received'; // Use blue icon
        }

        return [
            'booking_id' => $this->booking->id,
            'type' => $type,
            'title' => 'Booking ' . $status,
            'message' => 'The status of booking #' . $this->booking->id . ' has been updated to ' . $this->booking->status . '.',
        ];
    }
}
