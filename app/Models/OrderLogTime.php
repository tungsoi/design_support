<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLogTime extends Model
{
    protected $table = "order_log_times";
    const TYPE_PRODUCT = 2;
    const TYPE_ORDER = 1;
    protected $fillable = [
        'order_id',
        'order_status_id',
        'user_action_id',
        'type'
    ];

    public function statusLog()
    {
        return $this->hasOne(OrderProductStatus::class, 'id', 'order_status_id');
    }
}
