<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use SoftDeletes;

    protected $table = 'bids';

    protected $fillable = [
        'price',
        'description',
        'attach_file',
        'driver_id',
    ];

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }

    public function ride()
    {
        return $this->belongsTo('App\Models\Ride');
    }
}
