<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'author_id',
        'customer_id',
        'driver_id',
        'ride_id',
        'bid_id',
        'comments',
        'on_time',
        'on_budget',
        'rating'
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }

    public function job()
    {
        return $this->belongsTo('App\Models\Ride');
    }

    public function bid()
    {
        return $this->belongsTo('App\Models\Bid');
    }
}
