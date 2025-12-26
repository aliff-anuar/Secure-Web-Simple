<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'booking_date',
        'booking_time',
        'user_id',
    ];

    // Relationship: Booking belongs to a User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
