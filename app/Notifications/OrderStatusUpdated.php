<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $status;
    protected $type; // optional: 'regular' or 'bulk'

    public function __construct($order, $status, $type = 'regular')
    {
        $this->order = $order;
        $this->status = $status;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🧾 Order #' . $this->order->id . ' Status Update')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your ' . ucfirst($this->type) . ' order status has been updated to:')
            ->line("**{$this->status}**")
            ->action('View Order', url("/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/" . $this->order->id))
            ->line('Thank you for using DobiPulse!');
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'Order Status Updated',
            'body' => "Order #{$this->order->id} is now **{$this->status}**.",
            'url' => "/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/" . $this->order->id,
            'order_id' => $this->order->id,
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Order Status Updated',
            'body' => "Order #{$this->order->id} is now {$this->status}.",
            'url' => "/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/" . $this->order->id,
            'order_id' => $this->order->id,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Order Status Updated',
            'body' => "Order #{$this->order->id} is now {$this->status}.",
            'url' => "/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/" . $this->order->id,
        ];
    }
}
