<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    protected $table = 'stripe_accounts';

    protected $fillable = [
        'account_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
