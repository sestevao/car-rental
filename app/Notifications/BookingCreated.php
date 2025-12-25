<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreated extends Notification
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Check if the notifiable user is the admin (simplistic check)
        $isAdmin = $notifiable->email === 'admin@example.com';

        if ($isAdmin) {
            return [
                'booking_id' => $this->booking->id,
                'type' => 'payment_received',
                'title' => 'Payment Received',
                'message' => 'Payment of £' . $this->booking->total_price . ' received for Booking #' . $this->booking->id,
            ];
        }

        return [
            'booking_id' => $this->booking->id,
            'type' => 'booking_confirmed',
            'title' => 'Booking Confirmed',
            'message' => 'Booking #' . $this->booking->id . ' for ' . $this->booking->car->make . ' ' . $this->booking->car->model . ' has been created.',
        ];
    }
}
