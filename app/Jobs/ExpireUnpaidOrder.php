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

class ExpireUnpaidOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        Log::info("⌛ Checking unpaid order #{$this->orderId}");

        $order = Order::find($this->orderId);

        if (!$order) {
            Log::warning("❌ Order #{$this->orderId} not found");
            return;
        }

        if ($order->status !== 'pending') {
            Log::info("⏭️ Order #{$this->orderId} already paid or cancelled");
            return;
        }

        $order->delete();
        Log::info("🗑️ Order #{$this->orderId} deleted (unpaid)");

        if ($order->machine_id) {
            $machine = Machine::find($order->machine_id);
            if ($machine) {
                $machine->status = 'available';
                $machine->save();
                Log::info("✅ Machine #{$machine->id} released from unpaid order");
            }
        }
    }
}
