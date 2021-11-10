<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Cancel extends RowAction
{
    public $name = 'cancel';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function render()
    {
        $route = "";
        $url = "";
        $icon = "fa-times";
        $id = "";
        $color_btn = "btn-danger";
        $title = "Huỷ đơn hàng";
        return '<a target="_blank" href="'. $route .'" data-url="'.$url.'" data-id="'.$id.'" class="btn btn-xs '.$color_btn.'" data-toggle="tooltip" title="'.$title.'">
                <i class="fa '.$icon.'"></i>
            </a>';
    }

    public function __toString()
    {
        return $this->render();
    }


}
