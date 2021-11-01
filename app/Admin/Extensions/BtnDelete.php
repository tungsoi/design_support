<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Illuminate\Http\Request;


class BtnDelete
{
    protected $id;
    protected $url;
    protected $title;
    protected $icon;
    protected $color_btn;
    protected $status;

    public function __construct($id, $url, $title, $icon, $color_btn,$status)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->color_btn = $color_btn;
        $this->status = $status;
    }

    protected function script()
    {
        return <<<SCRIPT
        $('.grid-row-custom-delete').on('click', function () {
            console.log('.$this->url.','url');
            console.log('.$this->id.','id');
            console.log('.$this->title.','title');
            console.log('.$this->color_btn.','color_btn');
            console.log('.$this->status.','status');
            let url = $(this).data('url');
            console.log(url,'00000');
            let id = $(this).data('id');
            let title = $(this).data('title');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn thay đổi trạng thái ?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Huỷ bỏ'
            }).then((result) => {
                $('.loading-overlay').show();
                if (result.value == true && result.dismiss == undefined) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax(
                    {
                        url: url,
                        type: 'POST', // replaced from put
                        data: {
                            'id':$this->id,
                            'status':$this->status,
                        },
                        success: function (response)
                        {
                            if (response.isRedirect) {
                                setTimeout(function () {
                                    window.location.href = response.url;
                                }, 1000);
                            } else {
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            }

                        }
                    });
                } else {
                    $('.loading-overlay').hide();
                }
            })

        });

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return '<a href="javascript:void(0);" data-url="'.$this->url.'" data-id="'.$this->id.'" class="grid-row-custom-delete btn btn-xs '.$this->color_btn.'" data-toggle="tooltip" title="'.$this->title.'">
                <i class="fa '.$this->icon.'"></i>
            </a>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
