<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Illuminate\Http\Request;


class BtnExport
{
    protected $id;
    protected $url;
    protected $title;
    protected $icon;
    protected $color_btn;

    public function __construct($id, $url, $title, $icon, $color_btn)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->color_btn = $color_btn;
    }


    protected function render()
    {
        $route = route('admin.orders.exportExcelDetailOrder', $this->id);
        return '<a target="_blank" href="'. $route .'" data-url="'.$this->url.'" data-id="'.$this->id.'" class="grid-row-custom-delete btn btn-xs '.$this->color_btn.'" data-toggle="tooltip" title="'.$this->title.'">
                <i class="fa '.$this->icon.'"></i>
            </a>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
