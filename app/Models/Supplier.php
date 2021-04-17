<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "suppliers";

    /**
     * Fields
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'mobile_phone'
    ];
}
