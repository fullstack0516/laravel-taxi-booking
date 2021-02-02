<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $table = 'chat_rooms';

    protected $fillable = [
        'room_id',
        'customer_name',
        'driver_name',
        'name',
        'private_flag'
    ];
}
