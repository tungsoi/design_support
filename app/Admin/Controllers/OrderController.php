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
use Encore\Admin\Admin as AdminJs;

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
        $grid->disableExport();
        $user = Admin::user();
        $grid->model()->where(function ($query) use ($user) {
            if ($user->is_customer == User::CUSTOMER) {
                $query->where('customer_id', $user->id);
            };
        });
        if ($user->is_customer == User::CUSTOMER) {
            $grid->disableCreateButton();
        }

        $grid->model()->orderBy('id', 'desc')
            ->with('products')
            ->with('statusText');

        $grid->expandFilter();
        $grid->filter(function ($filter) use ($user) {
            $filter->disableIdFilter();
            $filter->column(1 / 3, function ($filter) {
                $filter->like('id', 'Mã đơn hàng');
            });
            if ($user->is_customer != User::CUSTOMER) {
                $filter->column(1 / 3, function ($filter) {
                    $users = User::join('user_profiles', 'user_profiles.user_id', '=', 'admin_users.id')->pluck('user_profiles.company_name', 'admin_users.id')->all();
                    $filter->equal('customer_id', 'Khách hàng')
                        ->select($users);
                });
            }
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });

        $grid->column('number', 'STT');
        $grid->order_number('Mã đơn hàng')->display(function () {
            return 'NT-' . str_pad($this->id, 4, 0, STR_PAD_LEFT);
        })->label('primary');

        $grid->column('products', 'Số Sản phẩm')->display(function ($products) {
            return sizeof($products);
        });

        $grid->column('customer_id', 'Khách hàng')->display(function () {
            return $this->customer->profile->company_name ?? "";
        });
        $grid->column('status', 'Trạng thái')->display(function () {
            $color = $this->statusText->color;
            $name = $this->statusText->name;
            return "<span class='label label-{$color}'>{$name}</span>";
        });
        $grid->column('amount_products_price', 'Tổng tiền sản phẩm (VND)')->display(function () {
            return $this->amount_products_price ?  number_format($this->amount_products_price) : null;
        });
        // $grid->column('amount_ship_service', 'Tổng phí vận chuyển (VND)')->display(function () {
        //     return $this->amount_ship_service ?  number_format($this->amount_ship_service) : null;
        // });
        $grid->column('amount_other_service', 'Tổng phí phát sinh (VND)')->display(function () {
            return $this->amount_other_service ?  number_format($this->amount_other_service) : null;
        });
        $grid->column('discount_value', 'Tổng tiền giảm (VND)')->display(function () {
            return $this->discount_value ?  number_format($this->discount_value) : null;
        });
        $grid->column('total_amount', 'Tổng giá cuối (VND)')->display(function () {
            return $this->total_amount ?  number_format($this->total_amount) : null;
        });
        $grid->column('deposited', 'Đã cọc (VND)')->display(function () {
            return $this->deposited ?  number_format($this->deposited) : null;
        });
        $grid->column('owed', 'Còn lại (VND)')->display(function () {
            return number_format($this->getOwed());
        });
        // $grid->column('logs', 'Timeline')->display(function () {
        //     return "-";
        // });
        $grid->disableBatchActions();
        $funcThis = $this;
        $grid->actions(function ($actions) use ($funcThis, $user) {
            $actions->disableDelete();
            if ($user->is_customer == User::CUSTOMER) {
                $actions->disableEdit();
            }
            // $actions->disableEdit();
            // $actions->disableView();

            $flag = $this->row->checkStatus();
            $route = '/admin/orders/updateStatus';
            if ($user->is_customer != User::CUSTOMER) {
                if ($this->row->status == 1 && sizeof($this->row->products) > 0) {
                    $actions->append(new Deposite($actions->getKey()));
                } elseif ($this->row->status == 2) {
                    $actions->append(new UpdateStatus($this->row->id, 3, $route, 'Xác nhận đã đặt hàng', 'fa-check', 'btn-info'));
                } elseif ($this->row->status == 3 && $flag && sizeof($this->row->products) > 0) {
                    $actions->append(new UpdateStatus($this->row->id, 4, $route, 'Xác nhận thành công', 'fa-info-circle', 'btn-danger'));
                } elseif ($this->row->status == 4) {

                    $actions->append(new UpdateStatus($this->row->id, 5, $route, 'Xác nhận xoá đơn hàng', 'fa-times', 'btn-primary'));
                }
                if (sizeof($this->row->products) > 0) {
                    $actions->append(new ExportAmount($actions->getKey()));
                }
                if ($this->row->status == 4 && $flag && sizeof($this->row->products) > 0) {
                    $actions->append(new ExportShipBill($actions->getKey()));
                    $actions->append(new ExportPaymentBill($actions->getKey()));
                }
            }
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        // $show->field('id', __('ID'));

        $show->customer_id('Khách hàng')->as(function ($customer) {
            return $this->customer->profile->company_name;
        });
        $show->amount_products_price('Tổng tiền sản phẩm')->as(function ($val) {
            return number_format($val);
        });
        $show->deposited('Tiền cọc')->as(function ($val) {
            return number_format($val);
        });
        $show->amount_ship_service('Tiền vận chuyển')->as(function ($val) {
            return number_format($val);
        });
        $show->amount_other_service('Phí phát sinh')->as(function ($val) {
            return number_format($val);
        });
        $show->discount_value('Chiết khấu')->as(function ($val) {
            return number_format($val);
        });
        $show->total_amount('Tổng tiền')->as(function ($val) {
            return number_format($val);
        });
        $show->images_deposit('Ảnh đặt cọc')->image();

        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->products('Danh sách sản phẩm', function ($comments) {
            $comments->rows(function (Grid\Row $row) {
                $row->column('number', ($row->number + 1));
            });
            $comments->column('number', 'STT');
            $comments->status('Trạng thái')->display(function () {
                $color = $this->statusText->color;
                $name = $this->statusText->name;
                return "<span class='label label-{$color}'>{$name}</span>";
            });
            $comments->name_product('Tên sản phẩm');
            $comments->quality('Số lượng');
            $comments->quality('Giá tiền')->display(function () {
                return $this->quality ?  number_format($this->quality) : null;
            });
            $comments->amount('Thành tiền')->display(function () {
                return $this->amount ?  number_format($this->amount) : null;
            });
            $comments->classify('Phân loại');
            $comments->specify_detail('Chỉ định chi tiết');
            $comments->payment_type('Loại thanh toán');
            $comments->value_use_payment('Giá trị');
            $comments->service_price('Giá tiền vận chuyển')->display(function () {
                return $this->service_price ?  number_format($this->service_price) : null;
            });
            $comments->payment_amount('Thành tiền vận chuyển')->display(function () {
                return $this->payment_amount ?  number_format($this->payment_amount) : null;
            });
            $comments->payment_code('Mã giao dịch');
            $comments->transport_code('Mã vận đơn');
            $comments->note('Ghi chú');
            $comments->dvt('Đơn vị tính');
            $comments->link('Link sản phẩm');
            $comments->images('Ảnh sản phẩm')->display(function () {
                $array = $this->images;

                if ($array != null && sizeof($array) > 0) {
                    unset($array[0]);

                    return $array;
                }
            })->lightbox(['width' => 80, 'height' => 50]);
            $comments->textarea('Mô tả chất liệu');
            $comments->created_at('Ngày tạo');
            $comments->disableCreateButton();
            $comments->disableActions();
            $comments->disablePagination();
            $comments->disableCreateButton();
            $comments->disableFilter();
            $comments->disableRowSelector();
            $comments->disableColumnSelector();
            $comments->disableTools();
            $comments->disableExport();
            $comments->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->disableEdit();
                $actions->disableDelete();
            });
        });
        $show->panel()
            ->tools(function ($tools) {
                // $tools->disableEdit();
                // $tools->disableList();
                $tools->disableDelete();
            });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $urlScript = asset('assets/furn/js/order.js');
        Admin::html('<script type="text/javascript" src="' . $urlScript . '"></script> ');
        $form = new Form(new Order);

        $service = new PortalService();
        $form->column(6, function ($form) use ($service) {
            $form->select('customer_id', 'Khách hàng')->options($service->getListCustomer())->rules(['required']);
            $form->display('user_action_name', 'Người tạo')->default(Admin::user()->name);
            $form->display('action_time', 'Thời gian tạo')->default(now());
            $form->hidden('status')->default(1);
        });

        $form->column(6, function ($form) use ($service) {
            $form->currency('amount_products_price', 'Tổng tiền sản phẩm')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('default_deposite', 'Tiền phải cọc')->help('70% tổng tiền sản phẩm')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('deposited', 'Tiền đã cọc')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_ship_service', 'Tiền vận chuyển')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_other_service', 'Phí phát sinh')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('discount_value', 'Chiết khấu')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('total_amount', 'Tổng tiền')->digits(0)->symbol('VND')->readonly()->attribute(['style' => 'width: 100% !important;']);
        });

        $form->column(12, function ($form) use ($service) {

            $form->divider();
            $form->hasMany('products', '- Danh sách sản phẩm', function (Form\NestedForm $form) {
                $form->select('status', 'Trạng thái')->options(OrderProductStatus::pluck('name', 'id'))->default(1);
                $form->text('name_product', 'Tên sản phẩm')->rules(['required']);
                $form->number('quality', 'Số lượng')->default(1);
                $form->currency('price', 'Giá tiền')->digits(0)->symbol('VND');
                $form->currency('amount', 'Thành tiền')->digits(0)->symbol('VND')->readonly();
                $form->text('link', 'Link sản phẩm');
                $form->text('classify', 'Phân loại')->rules(['required']);
                $form->text('specify_detail', 'Chỉ định chi tiết');
                $form->select('payment_type', 'Loại thanh toán')->options(OrderProductStatus::PAYMENT_TYPE)->default(0);
                $form->currency('value_use_payment', 'Giá trị')->digits(2)->symbol('KG / M3');
                $form->currency('service_price', 'Giá tiền vận chuyển')->digits(0)->symbol('VND');
                $form->currency('payment_amount', 'Thành tiền vận chuyển')->digits(0)->symbol('VND')->readonly();
                $form->text('payment_code', 'Mã giao dịch');
                $form->text('transport_code', 'Mã vận đơn');
                $form->text('note', 'Ghi chú');
                $form->text('dvt', 'Đơn vị tính');
                $form->multipleFile('images', 'Ảnh')
                    ->removable();
                $form->textarea('description', 'Mô tả chất liệu');
            });
        });

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });
        $form->saving(function (Form $form) {
            // dd($form);
        });

        return $form;
    }

    public function exportExcelDetailOrder($id)
    {
        ExcelOrder::exportDetail($id);
    }

    public function exportExcelShipBill($id)
    {
        ExcelOrder::exportExcelShipBill($id);
    }

    public function exportExcelPaymentBill($id)
    {
        ExcelOrder::exportExcelPaymentBill($id);
    }

    public function deposite($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->formDeposite()->edit($id));
    }


    public function updateStatus(Request $request)
    {
        $order = Order::find($request->id);
        $data = [
            'status'    =>  $request->status
        ];
        if ($request->status == 3) {
            $data['user_id_ordered']    =  Admin::user()->id;
            $data['ordered_at'] =   now();
        } else if ($request->status == 4) {
            $data['user_id_success']    =  Admin::user()->id;
            $data['success_at'] =   now();
        } else if ($request->status == 5) {
            $data['user_id_cancel']    =  Admin::user()->id;
            $data['cancel_at'] =   now();
        }

        // $checkExists = OrderLogTime::where('order_id', $request->id)->where('order_status_id', $request->status)->where('user_action_id', Admin::user()->id)->exists();
        // dd($checkExists);
        OrderLogTime::create([
            'order_id'  =>  $request->id,
            'order_status_id'   =>  $request->status,
            'user_action_id'    =>  Admin::user()->id
        ]);

        $order->update($data);

        admin_toastr('Lưu thành công', 'success');

        return response()->json([
            'status'    =>  true,
            'message'   =>  'success'
        ]);
    }
}
