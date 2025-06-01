<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'location', 'status'];

    public function active_order()
    {
        return $this->hasOne(Order::class, 'machine_id')
            ->whereIn('status', ['PayNow', 'pending', 'processing', 'approved'])
            ->latest('created_at');
    }



    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function checkout($orderId)
    {
        $order = Order::findOrFail($orderId);
        $machines = Machine::where('status', 'available')->get();

        return view('orders.checkout', compact('order', 'machines'));
    }


}
