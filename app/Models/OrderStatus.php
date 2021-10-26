<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "order_statuses";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'label'
    ];
}
