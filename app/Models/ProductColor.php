<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "product_colors";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'color'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
