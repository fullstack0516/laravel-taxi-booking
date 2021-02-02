<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use SpatialTrait;
    protected $table = 'profiles';

    protected $fillable = [
        'address',
        'bio',
        'google_username',
        'facebook_username',
        'avatar',
        'license_image',
    ];

    protected $spatialFields = [
        'location'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
