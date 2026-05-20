<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    // cho lưu vào db
    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date', 'total_price', 'status', 'customer_phone'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}