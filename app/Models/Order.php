<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        'customer_id',
        'amount_products_price',
        'default_deposite',
        'amount_ship_service',
        'amount_other_service',
        'deposited',
        'is_discount',
        'type_discount',
        'discount_value',
        'total_amount'
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class,'order_id');
    }
}
