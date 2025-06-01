<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RedemptionReward;

class RedemptionRewardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rewards = [
            [
                'icon' => '💳',
                'title' => '10% Discount (Cap RM10)',
                'points_required' => 15,
                'type' => 'percent', // ✅ FIXED
                'reward_value' => '10',
            ],
            [
                'icon' => '💳',
                'title' => '15% Discount (Cap RM15)',
                'points_required' => 30,
                'type' => 'percent', // ✅ FIXED
                'reward_value' => '15',
            ],
            [
                'icon' => '🧺',
                'title' => '1 Free Wash (RM5)',
                'points_required' => 60,
                'type' => 'product',
                'reward_value' => 'FreeWash',
            ],
            [
                'icon' => '🔥',
                'title' => '1 Free Dry (RM4)',
                'points_required' => 60,
                'type' => 'product',
                'reward_value' => 'FreeDry',
            ],
            [
                'icon' => '🎟️',
                'title' => 'RM4 Off Coupon',
                'points_required' => 60,
                'type' => 'fixed',
                'reward_value' => '4',
            ],
            [
                'icon' => '🎟️',
                'title' => 'RM8 Off Coupon',
                'points_required' => 80,
                'type' => 'fixed',
                'reward_value' => '8',
            ],
        ];

        foreach ($rewards as $reward) {
            RedemptionReward::create($reward);
        }
    }
}
