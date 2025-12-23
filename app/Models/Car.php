<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'price_per_day',
        'status',
        'image_url',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function details()
    {
        return $this->hasMany(CarDetail::class);
    }

    public function detail($name)
    {
        return $this->details->where('name', $name)->first()?->value;
    }
}
