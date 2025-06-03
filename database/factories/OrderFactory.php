<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Creates a new user automatically
            'total_amount' => $this->faker->randomFloat(2, 5, 50),
            'required_time' => 30,
            'status' => 'pending',
            // Add other required fields your Order model expects
        ];
    }
}
