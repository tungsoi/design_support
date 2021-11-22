<?php

namespace App\Models;

use App\User;
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
        'total_amount',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function statusText()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'status');
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function checkStatus()
    {
        return $this->products->where('status', '!=', 4)->count() > 0 ? false : true;
        // $status = true;
        // foreach ($this->products as $product) {
        //     if ($product->status != 4) {
        //         $status = false;
        //     }
        // }
        // return $status;
    }

    public function getOwed()
    {
        $owed =  $this->total_amount - $this->deposited;
        return $owed;
        # code...
    }
}
