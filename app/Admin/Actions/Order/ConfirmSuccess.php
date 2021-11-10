<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class ConfirmSuccess extends RowAction
{
    public $name = 'confirm-success';

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
        $color_btn = "btn-success";
        $title = "Xác nhận thành công";
        return '<a target="_blank" href="'. $route .'" data-url="'.$url.'" data-id="'.$id.'" class="btn btn-xs '.$color_btn.'" data-toggle="tooltip" title="'.$title.'">
                <i class="fa '.$icon.'"></i>
            </a>';
    }

    public function __toString()
    {
        return $this->render();
    }

}
