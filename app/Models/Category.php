<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use AdminBuilder;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "categories";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'parent_id',
        'is_show_shop',
        'avatar',
        'icon',
        'code'
    ];

    const ACTIVE = 1;
    const DEACTIVE = 0;

    public function products() {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }

    public function parent() {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id');
    }

    public function childrens() {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }
}
