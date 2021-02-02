<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    use SpatialTrait;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'address',
        'zip_code',
        'background_image',
        'country_code'
    ];

    protected $spatialFields = [
        'location',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function rides()
    {
        return $this->hasMany('App\Models\Ride');
    }
}
