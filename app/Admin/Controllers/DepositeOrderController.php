<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\Deposite;
use App\Admin\Actions\Order\ExportAmount;
use App\Admin\Actions\Order\ExportPaymentBill;
use App\Admin\Actions\Order\ExportShipBill;
use App\Admin\Actions\Order\UpdateStatus;
use App\Admin\Extensions\Excel\ExcelOrder;
use App\Admin\Service\PortalService;
use App\Models\Order;
use App\Models\OrderLogTime;
use App\Models\OrderProduct;
use App\Models\OrderProductStatus;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;

class DepositeOrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Dat coc đơn hàng';


    public function form()
    {

        $form = new Form(new Order());
        $form->currency('amount_products_price', 'Tổng tiền sản phẩm')->symbol('VND')->digits(0)->readonly();
        $form->currency('deposited', 'Tiền cọc')->symbol('VND')->digits(0)->required(); // tien khach hang chuyen khoan de vao coc
        $form->multipleFile('images_deposit', 'Ảnh')
            ->rules('mimes:jpeg,png,jpg')
            ->help('Ảnh đầu tiên sẽ hiển thị là ảnh đại diện')
            ->removable();
        $form->hidden('status');
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->saving(function (Form $form) {
            $form->status = 2;
            // dd($form);
        });
        $form->saved(function (Form $form) {
            OrderLogTime::create([
                'order_id'  =>  $form->model()->id,
                'order_status_id'   =>  2,
                'user_action_id'    =>  Admin::user()->id,
                'type' => OrderLogTime::TYPE_ORDER
            ]);
            return redirect()->route('admin.orders.index');
        });
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });
        return $form;
    }
}
