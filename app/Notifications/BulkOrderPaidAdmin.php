<?php

namespace App\Notifications;

use App\Models\BulkOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class BulkOrderPaidAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    protected $bulkOrder;

    public function __construct(BulkOrder $bulkOrder)
    {
        $this->bulkOrder = $bulkOrder;
    }

    public function via($notifiable)
    {
        return ['database']; // Add 'mail' if you also want email
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Bulk Order Paid',
            'message' => 'Order #' . $this->bulkOrder->id . ' has been paid by ' . $this->bulkOrder->user->name,
            'url' => route('admin.viewBulkOrderDetails', $this->bulkOrder->id),
        ];
    }
}

