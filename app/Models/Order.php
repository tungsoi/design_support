<?php

namespace App\Models;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use AdminBuilder;
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "orders";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'deposite',
        'total_item_amount',
        'discount_amount',
        'discount_reason',
        'other_amount',
        'final_amount',
        'is_discount',
        'is_bonus',
        'deposit',
        'deposited_at',
        'user_id_created',
        'user_id_deposited',
        'ordered_at',
        'user_id_ordered',
        'success_at',
        'user_id_success',
        'cancel_at',
        'user_id_cancel'
    ];

    public function action()
    {
        return $this->hasMany('App\Models\OrderAction', 'order_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function userCreate(){
        return $this->hasOne('App\User', 'id', 'user_id_created');
    }

    public function statusText() {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'status');
    }

    public function orderNumber() {
        return "NT".str_pad($this->id, 4, 0, STR_PAD_LEFT);
    }

    public function userDeposite(){
        return $this->hasOne('App\User', 'id', 'user_id_deposited');
    }

    public function userOrdered(){
        return $this->hasOne('App\User', 'id', 'user_id_success');
    }

    public function userSuccess(){
        return $this->hasOne('App\User', 'id', 'user_id_ordered');
    }
    public function userCancel(){
        return $this->hasOne('App\User', 'id', 'user_id_cancel');
    }
}
