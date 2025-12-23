<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDetail extends Model
{
    protected $fillable = ['name', 'value'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
