<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Foundation\Bus\Dispatchable;


class PickupReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📦 Pickup Reminder - Order #' . $this->order->id)
            ->greeting('Hi ' . $notifiable->name)
            ->line("Your bulk order #{$this->order->id} is ready for pickup.")
            ->action('View Order', url('/bulk-orders/' . $this->order->id))
            ->line('Thank you for choosing DobiPulse!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pickup Reminder',
            'body' => "Your bulk order #{$this->order->id} is ready for pickup.",
            'url' => '/bulk-orders/' . $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Pickup Reminder',
            'body' => "Your bulk order #{$this->order->id} is ready for pickup.",
            'url' => '/bulk-orders/' . $this->order->id,
        ]);
    }
}
