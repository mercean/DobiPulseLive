<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LoyaltyPointsUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $points;

    public function __construct($points)
    {
        $this->points = $points;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎁 Loyalty Points Updated')
            ->greeting("Hi {$notifiable->name},")
            ->line("You just earned {$this->points} loyalty points!")
            ->action('View Your Points', url('/loyalty'))
            ->line('Keep using DobiPulse and earn more rewards!');
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'Loyalty Points Updated',
            'body' => "You earned {$this->points} new loyalty points!",
            'url' => '/loyalty',
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Loyalty Points Updated',
            'body' => "You earned {$this->points} new loyalty points!",
            'url' => '/loyalty',
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Loyalty Points Updated',
            'body' => "You earned {$this->points} new loyalty points!",
            'url' => '/loyalty',
        ];
    }
}
