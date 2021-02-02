<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'payment_intent_id',
        'amount',
        'customer_id',
        'payment_method_id',
        'currency',
        'description',
    ];

    public function scopeRecent($query)
    {
        return $query->where('created_at', '>', (new \Carbon\Carbon)->submonths(1) );
    }
}
