<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Deposite extends RowAction
{
    public $name = 'deposite';

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function render()
    {
        $route = route('admin.deposite_orders.edit', $this->id);
        $url = "";
        $icon = "fa-times";
        $id = "";
        $color_btn = "btn-warning";
        $title = "Đặt cọc đơn hàng";
        return '<a href="' . $route . '" data-url="' . $url . '" data-id="' . $id . '" class="btn btn-xs ' . $color_btn . '" data-toggle="tooltip" title="' . $title . '">
                <i class="fa ' . $icon . '"></i>
            </a>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
