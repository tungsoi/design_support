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
        'images_deposit'
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
    }

    public function getImagesDepositAttribute($pictures)
    {
        if (is_string($pictures)) {
            return json_decode($pictures, true);
        }

        return $pictures;
    }

    public function setImagesDepositAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['images_deposit'] = json_encode($pictures);
        }
    }

    public function logs()
    {
        return $this->hasOne(OrderLogTime::class, 'order_id', 'id');
    }
}
