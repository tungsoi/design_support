<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "product_properties";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'site',
        'lenght',
        'width',
        'height',
        'material_id',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }

}
