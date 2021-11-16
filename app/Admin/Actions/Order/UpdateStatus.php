<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Admin;

class UpdateStatus extends RowAction
{
    public $name = 'confirm-ordered';
    protected $status;
    protected $id;
    protected $url;
    protected $title;
    protected $icon;
    protected $color_btn;

    public function __construct($id, $status, $url, $title, $icon, $color_btn)
    {
        $this->id = $id;
        $this->status = $status;
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->color_btn = $color_btn;
    }

    protected function script()
    {
        return <<<SCRIPT
        $('.grid-row-custom-delete').on('click', function () {

            let url = $(this).data('url');
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-status');
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
                            'id': id,
                            'status': status,
                        },
                        success: function (response)
                        {
                            console.log(response);
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
    public function render()
    {
        Admin::script($this->script());
        return '<a href="javascript:void(0);" data-url="' . $this->url . '" data-status="' . $this->status . '" data-id="' . $this->id . '"  class="grid-row-custom-delete btn btn-xs ' . $this->color_btn . '" data-toggle="tooltip" title="' . $this->title . '">
            <i class="fa ' . $this->icon . '"></i>
        </a>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
