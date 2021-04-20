<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use AdminBuilder;

    /**
     * Table name
     */
    protected $table = "materials";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title'
    ];

    /**
     * Format output
     *
     * @var array
     */
    protected $casts = [
        'created_at'  => 'datetime:H:i | d-m-Y'
    ];

    public function category() {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}
