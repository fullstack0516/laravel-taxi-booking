<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RideType extends Model
{
    protected $table = 'ride_types';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'level',
    ];

    public function rides()
    {
        return $this->hasMany('App\Models\Ride', 'ride_type_id');
    }
}
