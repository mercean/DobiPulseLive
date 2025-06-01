<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Promotion.php
class Promotion extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'value',
        'start_date', 'end_date', 'auto_apply', 'code',
        'promo_image', // ✅ Add this
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'auto_apply' => 'boolean',
    ];

}
