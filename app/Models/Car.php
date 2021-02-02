<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    protected $fillable = [
        'name',
        'year_of_model',
        'license_number',
        'license_image',
        'car_number_plate'
    ];

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }
}
