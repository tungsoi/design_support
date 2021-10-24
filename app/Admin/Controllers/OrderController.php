<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Order;
use App\Models\OrderAction;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\Auth;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Đơn hàng';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $grid->expandFilter();
        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                $filter->like('name', 'Tên nhà cung cấp');
            });
            $filter->column(1/3, function ($filter) {
                $filter->like('mobile_phone', 'Số điện thoại');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');
        $grid->column('user_id', 'Khách hàng')->display(function (){
            $user = $this->user;
            return $user->username ?? null;
        });
        $grid->column('total_item_amount', 'Tổng tiền')->display(function (){
            return number_format($this->total_item_amount);
        });
        $grid->column('deposit', 'Tổng cọc')->display(function (){
            return number_format($this->deposit);
        });
//        $grid->column('number', 'Thời gian cọc');
//        $grid->column('number', 'Tiền còn lại');
        $grid->column('status', 'Trạng thái');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
        });
        return $grid;
    }
    /*
     * detail
     */

    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->name('Tên danh mục');
        $show->created_at();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);
        Admin::style('
        .col-md-3 .col-sm-2, .col-md-3 .col-sm-8{width:100% !important; text-align: left;}
        .col-md-3, .col-md-9 {border-right: 1px solid #b3b3b3 !important}
        .col-md-3 hr, .col-md-9 hr {border-top: 1px solid #b3b3b3;}
        ');

        $form->column(3, function ($form) {
            $customers = User::whereIsCustomer(User::CUSTOMER)->orderBy('id', 'desc')->get();
            $temp_customer = [];
            foreach ($customers as $customer)
            {
                $temp_customer[$customer->id] = $customer->profile->code . " - " .$customer->profile->company_name;
            }
            $form->select('user_id', 'Khách hàng')->options($temp_customer)->rules('required')->attribute(['class' => 'custom-width']);
//            $form->select('user_id', 'Sản ')->options($temp_customer)->rules('required')->attribute(['class' => 'custom-width']);
            $form->display('action.created_datetime', 'Thời gian tạo - Người thực hiện')->default(date('H:i | d-m-Y', strtotime(now())) . " - " .Admin::user()->name)->disable();
            $form->divider();
            $form->radio('is_discount','Giảm giá')
                ->options([
                    1 =>'Không',
                    2 =>'Có',
                ])->when(1, function (Form $form) {

                })->when(2, function (Form $form) {
                    $form->currency('discount_amount', 'Tiền giảm giá')
                    ->width(100)
                    ->symbol('VND')
                    ->digits(0);
                    $form->text('discount_reason', 'Lý do giảm giá');
                })->default(1);
            $form->radio('is_bonus','Phí phát sinh')
                ->options([
                    1 =>'Không',
                    2 =>'Có',
                ])->when(1, function (Form $form) {

                })->when(2, function (Form $form) {
                    $form->currency('other_amount', 'Tiền phí phát sinh')
                    ->width(100)
                    ->symbol('VND')
                    ->digits(0);
                })->default(1);
            $form->divider();
            $form->currency('total_item_amount', 'Tổng tiền sản phẩm')
                ->width(100)
                ->readonly()
                ->symbol('VND')
                ->digits(0)
                ->attribute(["data_amount" => 0]);
            $form->divider();

            $form->currency('deposit', 'Tổng tiền cọc ')
             ->width(100)
                ->readonly()
                ->symbol('VND')
                ->digits(0);
        });
        $form->column(9, function ($form) {
            $form->hasMany('items', "-", function (Form\NestedForm $form) {
                $products = Product::orderBy('id', 'desc')->get();
                $temp_product = [];
                foreach ($products as $product)
                {
                    $temp_product[$product->id] = $product->code . " - " .$product->name;
                }

                $form->select('product_id', 'Sản phẩm')
                ->options($temp_product)
//                ->loads(
//                    ['product_property_id', 'product_color_id'],
//                    ['/admin/products/product_properties', '/admin/products/product_colors']
//                )
                ->attribute(['id' => 'product_id'])
                ->rules('required');
                $form->number('order_qty', 'Số lượng đặt mua (1)')->rules('required')->width('100%')->default(1);

                $form->select('product_property_id', 'Option sản phẩm')
                ->options()
//                ->load('price', '/admin/products/product_property_price')
                ->rules('required');

                $form->currency('price', 'Giá tiền sản phẩm  (2)') ->readonly()
                    ->width(100)
                    ->symbol('VND')
                    ->digits(0);

                $form->currency('amount_one_item', 'Tổng tiền sản phẩm (3) = (1) * (2)')
                    ->readonly()
                    ->width(100)
                    ->symbol('VND')
                    ->digits(0);
                $form->hidden('picture');
//                dd($form->pictures_id);die();
                $route_get_product = route('admin.products.getInfoProduct');
                $form->html(view('furns.partials.picture_product', [
                    'route_get_product' => $route_get_product,
                ]),'Ảnh');
//                    ->removable();
            })->attribute(['class' => 'form-property']);
        });
        $form->confirm('Xác nhận lưu dữ liệu đơn hàng ?');

        $form->saved(function (Form $form) {

            $action = OrderAction::whereOrderId($form->model()->id)->first();
            if ($action == 0)
            {
                OrderAction::create([
                    'order_id'  =>  $form->model()->id,
                    'created_user_id'   =>  Admin::user()->id,
                    'created_datetime'  =>  now()
                ]);
            }
        });

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        Admin::js('assets/furn/js/script_design.js');

        return $form;
    }
}
