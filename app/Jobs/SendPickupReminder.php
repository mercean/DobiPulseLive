<?php

namespace App\Jobs;

use App\Models\BulkOrder;
use App\Notifications\PickupReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log; // ✅ Add this

class SendPickupReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bulkOrderId;

    public function __construct($bulkOrderId)
    {
        $this->bulkOrderId = $bulkOrderId;
    }

    public function handle(): void
    {
        Log::info("🔔 Handling pickup reminder for order ID: {$this->bulkOrderId}");

        $order = BulkOrder::with('user')->find($this->bulkOrderId);

        if ($order) {
            Log::info("🔍 Order found: ID {$order->id}, status: {$order->status}");

            if ($order->status === 'waiting pickup') {
                Log::info("✅ Sending notification to user ID: {$order->user->id}");
                $order->user->notify(new PickupReminder($order));
            } else {
                Log::warning("⚠️ Order ID {$order->id} has invalid status '{$order->status}' for notification.");
            }
        } else {
            Log::error("❌ Bulk order with ID {$this->bulkOrderId} not found.");
        }
    }
}
