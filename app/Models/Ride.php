<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ride extends Model
{
    use SoftDeletes;
    use SpatialTrait;

    protected $table = 'rides';

    protected $fillable = [
        'title',
        'ride_type_id',
        'city_id',
        'seats',
        'address_from',
        'address_to',
        'price_min',
        'price_max',
        'description',
        'file_path',
        'time_to',
        'time_from',
        'driver_id',
        'accepted_salary'
    ];

    protected $spatialFields = [
        'location_from',
        'location_to'
    ];

    protected $dates = [
        'time_to',
        'time_from',
    ];

    public function type()
    {
        return $this->belongsTo('App\Models\RideType', 'ride_type_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function bids()
    {
        return $this->hasMany('App\Models\Bid');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\Driver', 'driver_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
