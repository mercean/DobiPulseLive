@component('mail::message')
# Bulk Order Receipt

Hi {{ $order->user->name }},

Your bulk laundry order has been paid successfully.

---

**Order ID:** {{ $order->id }}  
**Cloth Type:** {{ $order->cloth_type }}  
**Weight:** {{ $order->load_kg }} kg  
**Drop-off:** {{ $order->load_arrival_date }} at {{ $order->load_arrival_time }}  
**Pickup:** {{ $order->pickup_date }} at {{ $order->pickup_time }}  
**Total Paid:** MYR {{ number_format($order->price, 2) }}  

---

@component('mail::button', ['url' => route('bulk.orders.index')])
View My Orders
@endcomponent

Thanks,<br>
DobiPulse Team
@endcomponent
