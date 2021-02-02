<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    use SpatialTrait;
    protected $table = 'driver_locations';

    protected $fillable = [
        'address',
    ];

    protected $spatialFields = [
        'location',
    ];

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }
}
