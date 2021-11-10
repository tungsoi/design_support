<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\Cancel;
use App\Admin\Actions\Order\ConfirmOrdered;
use App\Admin\Actions\Order\ConfirmSuccess;
use App\Admin\Actions\Order\Deposite;
use App\Admin\Actions\Order\ExportAmount;
use App\Admin\Actions\Order\ExportPaymentBill;
use App\Admin\Actions\Order\ExportShipBill;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Order;
use App\Admin\Service\PortalService;
use App\Models\OrderProductStatus;
use Encore\Admin\Auth\Database\Menu;
use App\User;
use Encore\Admin\Facades\Admin;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Danh sách đơn hàng';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $grid->model()->orderBy('id', 'desc')
        ->with('products')
        ->with('statusText');

        $grid->expandFilter();
        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                $filter->like('id', 'Mã đơn hàng');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });

        $grid->column('number', 'STT');
        $grid->order_number('Mã đơn hàng')->display(function () {
            return 'NT-'.str_pad($this->id, 4, 0, STR_PAD_LEFT);
        })->label('primary');
        $grid->column('products', 'Sản phẩm')->display(function ($products) {
            return sizeof($products);
        });
        $grid->column('customer_id', 'Khách hàng')->display(function () {
            return $this->customer->profile->company_name ?? "";
        });
        $grid->column('status', 'Trạng thái')->display(function () {
            $color = $this->statusText->color;
            $name  = $this->statusText->name;
            return "<span class='label label-{$color}'>{$name}</span>";
        });
        $grid->column('amount_products_price', 'Tổng tiền sản phẩm (VND)');
        $grid->column('amount_ship_service', 'Tổng phí vận chuyển (VND)');
        $grid->column('amount_other_service', 'Tổng phí phát sinh (VND)');
        $grid->column('discount_value', 'Tổng tiền giảm (VND)');
        $grid->column('total_amount', 'Tổng giá cuối (VND)');
        $grid->column('deposited', 'Đã cọc (VND)');
        $grid->column('owed', 'Còn lại (VND)')->display(function () {
            return "-";
        });
        $grid->column('logs', 'Timeline')->display(function () {
            return "-";
        });

        $grid->disableBatchActions();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            // $actions->disableEdit();
            // $actions->disableView();

            $actions->append(new Deposite());
            $actions->append(new Cancel());
            $actions->append(new ConfirmOrdered());
            $actions->append(new ConfirmSuccess());
            $actions->append(new ExportAmount());
            $actions->append(new ExportShipBill());
            $actions->append(new ExportPaymentBill());
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        Admin::js('assets/furn/js/order.js');
        $form = new Form(new Order);

        $service = new PortalService();

        $form->column(6, function ($form) use ($service) {
            $form->select('customer_id')->options($service->getListCustomer());
            $form->display('user_action_name')->default(Admin::user()->name);
            $form->display('action_time')->default(now());
        });

        $form->column(6, function ($form) use ($service) {
            $form->currency('amount_products_price')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('default_deposite')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_ship_service')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_other_service')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('discount_value')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('total_amount')->digits(0)->symbol('VND')->readonly()->attribute(['style' => 'width: 100% !important;']);
        });

        $form->column(12, function ($form) use ($service) {

            $form->divider();
            $form->hasMany('products', '- Danh sách sản phẩm', function (Form\NestedForm $form) {
                $form->select('status')->options(OrderProductStatus::pluck('name', 'id'))->default(1)->disable();
                $form->number('quality')->default(1);
                $form->currency('price')->digits(0)->symbol('VND');
                $form->currency('amount')->digits(0)->symbol('VND')->readonly();
                $form->text('link');
                $form->text('description');
                $form->select('payment_type')->options(OrderProductStatus::PAYMENT_TYPE)->default(0);
                $form->currency('value_use_payment')->digits(2)->symbol('KG / M3');
                $form->currency('service_price')->digits(0)->symbol('VND');
                $form->currency('payment_amount')->digits(0)->symbol('VND');
                $form->text('transport_code');
                $form->text('payment_code');
                $form->text('note');
                $form->multipleFile('images', 'Ảnh')
            ->rules('mimes:jpeg,png,jpg')
            ->removable();
            });
        });

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        return $form;
    }
}
