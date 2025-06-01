<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Machine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MarkMachineAvailable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        Log::info("🧼 Running MarkMachineAvailable for Order #{$this->orderId}");

        $order = Order::find($this->orderId);

        // ✅ Only unlock machine if order is approved (paid and completed)
        if (!$order || $order->status !== 'approved') {
            Log::info("⏭️ Skipping: Order #{$this->orderId} not approved or already handled.");
            return;
        }

        if ($order->machine_id) {
            $machine = Machine::find($order->machine_id);
            if ($machine) {
                $machine->status = 'available';
                $machine->save();
                Log::info("✅ Machine #{$machine->id} unlocked after wash complete.");
            } else {
                Log::warning("⚠️ Machine not found for Order #{$this->orderId}");
            }
        }
    }
}
