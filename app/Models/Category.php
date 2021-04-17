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
        'avatar'
    ];

    const ACTIVE = 1;
    const DEACTIVE = 0;

    public function products() {
        return Product::whereCategoryId($this->id)->count();
    }
}
