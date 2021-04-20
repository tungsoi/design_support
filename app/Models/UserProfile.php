<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "user_profiles";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'mobile_phone',
        'email',
        'code',
        'discount_percent',
        'min_deposite_percent'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
