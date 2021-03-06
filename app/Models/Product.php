<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "products";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'avatar',
        'pictures',
        'supplier_id',
        'link_3d',
        'quantity_sold',
        'link_order'
    ];

    public function getPicturesAttribute($pictures)
    {
        if (is_string($pictures)) {
            return json_decode($pictures, true);
        }

        return $pictures;
    }

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function category() {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    public function properties()
    {
        return $this->hasMany('App\Models\ProductProperty', 'product_id')->orderBy('price', 'asc');
    }

    public function supplier() {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }

    public function colors()
    {
        return $this->hasMany('App\Models\ProductColor', 'product_id');
    }
}
