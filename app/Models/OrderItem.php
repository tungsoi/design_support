<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "order_items";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_property_id',
        'product_color_id',
        'order_qty',
        'reality_qty',
        'price',
        'picture'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }

    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function productProperty() {
        return $this->hasOne('App\Models\ProductProperty', 'id', 'product_property_id');
    }

    public function productColor() {
        return $this->hasOne('App\Models\ProductColor', 'id', 'product_color_id');
    }

    public function amount() {
        return $this->reality_qty * $this->price;
    }
}
