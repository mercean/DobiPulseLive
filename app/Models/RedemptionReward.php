<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedemptionReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'points_required',
        'type',
        'reward_value',
    ];
}
