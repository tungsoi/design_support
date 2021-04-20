<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "order_actions";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'created_datetime',
        'created_user_id',
        'received_datetime',
        'received_user_id',
        'deposited_datetime',
        'deposited_user_id',
        'successed_datetime',
        'successed_user_id',
        'cancled_datetime',
        'cancled_user_id',
        'cancle_reason'
    ];

    /**
     * Format output
     *
     * @var array
     */
    protected $casts = [
        'created_datetime'  => 'datetime:H:i | d-m-Y',
        'received_datetime'  => 'datetime:H:i | d-m-Y',
        'deposited_datetime'  => 'datetime:H:i | d-m-Y',
        'successed_datetime'  => 'datetime:H:i | d-m-Y',
        'cancled_datetime'  => 'datetime:H:i | d-m-Y',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
}
