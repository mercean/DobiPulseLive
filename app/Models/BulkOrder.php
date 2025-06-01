<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'cloth_type',
        'load_kg',
        'load_arrival_date',
        'load_arrival_time',
        'pickup_date',
        'pickup_time',
        'status',
        'user_id',  // Add user_id to the fillable array
    ];

    // Define the relationship between BulkOrder and User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
