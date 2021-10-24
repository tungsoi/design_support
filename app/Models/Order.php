<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "orders";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'deposite',
        'total_item_amount',
        'discount_amount',
        'discount_reason',
        'other_amount',
        'final_amount',
        'is_discount',
        'is_bonus',
        'deposit'
    ];

    public function action()
    {
        return $this->hasMany('App\Models\OrderAction', 'order_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
