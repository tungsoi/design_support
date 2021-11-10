<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLogTime extends Model
{
    protected $table = "order_log_times";

    protected $fillable = [
        'order_id',
        'order_status_id',
        'user_action_id'
    ];
}
