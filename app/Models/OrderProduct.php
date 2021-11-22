<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = "order_products";

    protected $fillable = [
        'order_id',
        'link',
        'images',
        'description',
        'quality',
        'price',
        'amount',
        'status',
        'note',
        'transport_code',
        'payment_code',
        'payment_type',
        'value_use_payment',
        'service_price',
        'payment_amount',
        'name_product',
        'classify',
        'specify_detail',
        'dvt'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function statusText()
    {
        return $this->hasOne(OrderProductStatus::class, 'id', 'status');
    }

    public function getImagesAttribute($images)
    {
        if (is_string($images)) {
            return json_decode($images, true);
        }

        return $images;
    }

    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }
}
