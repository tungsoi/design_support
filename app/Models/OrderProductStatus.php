<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductStatus extends Model
{
    protected $table = "order_product_statuses";

    protected $fillable = [
        'name',
        'color'
    ];

    const PAYMENT_TYPE = [
        'KG',
        'Khối'
    ];
}
