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

class OrderedController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Danh sách đơn hàng đã đặt';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderProduct());

        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1 / 3, function ($filter) {
                $filter->like('id', 'Mã đơn hàng');
            });
            $filter->column(1 / 3, function ($filter) {

                $customers = User::whereIsCustomer(1)->with('profile')->get();
                $customer_used = [];

                foreach ($customers as $customer) {
                    $customer_used[$customer->id] = $customer->profile->company_name;
                }
                $filter->where(function ($query) {
                    $customer_id = $this->input;
                    $order_ids = Order::where('customer_id', $customer_id)->pluck('id')->toArray();
                    // dd($order_ids);
                    $query->whereIn('order_id', $order_ids);
                }, 'Khách hàng', 'customer_id')->select($customer_used);
            });
            $filter->column(1 / 3, function ($filter) {
                $filter->equal('status', 'Trạng thái')
                    ->select(OrderProductStatus::all()->pluck('name', 'id'));
            });
        });
        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });
        $grid->column('number', 'STT');
        // $grid->column('id', 'Id');
        $grid->column('order_id', 'Người đặt')->display(function () {
            $order = $this->order ?? null;
            $name = $order->customer->profile->company_name ?? null;
            return '<div style="width:200px;" >' . $name . '</div>';
        })->style('max-width:200px;');

        $grid->column('name_product', 'Tên sản phẩm')->setAttributes(['max-width' => ' 300px']);
        $grid->column('quality', 'Số lượng');
        $grid->column('price', 'Giá tiền')->display(function () {
            return $this->price ?  number_format($this->price) : null;
        })->width(200);
        $grid->column('amount', 'Thành tiền')->display(function () {
            return $this->amount ?  number_format($this->amount) : null;
        });
        $grid->column('status', 'Trạng thái')->display(function () {
            $color = $this->statusText->color;
            $name = $this->statusText->name;
            return "<span class='label label-{$color}'>{$name}</span>";
        });
        $grid->column('classify', 'Phân loại');
        $grid->column('specify_detail', 'Chỉ định chi tiết');
        $grid->column('payment_type', 'Loại thanh toán');
        $grid->column('value_use_payment', 'Giá trị')->display(function () {
            return $this->value_use_payment ?  number_format($this->value_use_payment) : null;
        });
        $grid->column('service_price', 'Giá tiền vận chuyển')->display(function () {
            return $this->service_price ?  number_format($this->service_price) : null;
        });
        $grid->column('payment_amount', 'Thành tiền vận chuyển')->display(function () {
            return $this->payment_amount ?  number_format($this->payment_amount) : null;
        });
        $grid->column('payment_code', 'Mã giao dịch');
        $grid->column('transport_code', 'Mã vận đơn');
        $grid->column('note', 'Ghi chú');
        $grid->column('dvt', 'Đơn vị tính');
        $grid->column('images', 'Ảnh sản phẩm')->display(function () {
            $array = $this->images;

            if ($array != null && sizeof($array) > 0) {
                unset($array[0]);

                return $array;
            }
        })->lightbox(['width' => 80, 'height' => 50]);
        $grid->column('link', 'Link sản phẩm');
        $grid->disableColumnSelector();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
            $actions->disableEdit();
        });
        return $grid;
    }
    protected function detail($id)
    {
        $show = new Show(OrderProduct::findOrFail($id));

        $show->field('status', 'Trạng thái');
        $show->field('name_product', 'Tên sản phẩm');
        $show->field('quality', 'Số lượng');
        $show->field('discount_value', 'Chiết khấu');
        $show->field('total_amount', 'Tổng tiền');
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }
}
