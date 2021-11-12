<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class ExportAmount extends RowAction
{

    public function __construct($id)
    {
        $this->id = $id;
    }
    public $name = 'export-amount';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function render()
    {
        $route = route('admin.orders.exportExcelDetailOrder', $this->id);
        $url = "";
        $icon = "fa-download";
        $id = "";
        $color_btn = "btn-success";
        $title = "Xuất báo giá";
        return '<a target="_blank" href="'. $route .'" data-url="'.$url.'" data-id="'.$id.'" class="btn btn-xs '.$color_btn.'" data-toggle="tooltip" title="'.$title.'">
                <i class="fa '.$icon.'"></i>
            </a>';
    }

    public function __toString()
    {
        return $this->render();
    }

}
