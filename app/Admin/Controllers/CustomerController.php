<?php

namespace App\Admin\Controllers;

use App\Models\UserProfile;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;
use Encore\Admin\Controllers\AdminController;
use App\User;

class CustomerController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    protected function title()
    {
        return 'Khách hàng';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->model()->whereIsCustomer(User::CUSTOMER)->orderBy('id', 'desc');

        $grid->expandFilter();
        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                $filter->like('username', 'Tên đăng nhập');
            });
            $filter->column(1/3, function ($filter) {
                $filter->where(function ($query) {

                    $query->whereHas('profile', function ($query) {
                        $query->where('code', 'like', "%{$this->input}%");
                    });

                }, 'Mã khách hàng');
            });
            $filter->column(1/3, function ($filter) {
                $filter->where(function ($query) {

                    $query->whereHas('profile', function ($query) {
                        $query->where('email', 'like', "%{$this->input}%");
                    });

                }, 'Email công ty');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');
        $grid->avatar('Ảnh đại diện')->lightbox(['width' => 50, 'height' => 50]);
        $grid->profile()->code('Mã khách hàng');
        $grid->column('username', trans('admin.username'));
        $grid->profile()->company_name('Tên công ty');
        $grid->profile()->address('Địa chỉ');
        $grid->profile()->mobile_phone('Số điện thoại');
        $grid->company_email('Email công ty')->display(function () {
            return $this->profile->email ?? "";
        });
        $grid->column('roles', trans('admin.roles'))->pluck('name')->label();
        $states = [
            'on'  => ['value' => User::ACTIVE, 'text' => 'Mở', 'color' => 'success'],
            'off' => ['value' => User::DEACTIVE, 'text' => 'Khoá', 'color' => 'danger'],
        ];
        $grid->column('status', 'Trạng thái')->switch($states);
        $grid->column('created_at', trans('admin.created_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->disableView();
        });

        $grid->disableBatchActions();
        $grid->disableColumnSelector();
        $grid->paginate(100);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $roleModel = config('admin.database.roles_model');
        $userTable = config('admin.database.users_table');
        $connection = config('admin.database.connection');

        $form = new Form(new User());

        $form->tab('Thông tin đăng nhập', function ($form) use ($roleModel, $userTable, $connection) {
            $form->text('username', trans('admin.username'))
            ->creationRules(['required', "unique:{$connection}.{$userTable}"])
            ->updateRules(['required', "unique:{$connection}.{$userTable},username,{{id}}"]);
            $form->password('password', trans('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);
            $form->multipleSelect('roles', trans('admin.roles'))->options($roleModel::all()->pluck('name', 'id'))->default(2)->readonly();
            $form->hidden('is_customer')->default(User::CUSTOMER);
            $states = [
                'on'  => ['value' => User::ACTIVE, 'text' => 'Mở', 'color' => 'success'],
                'off' => ['value' => User::DEACTIVE, 'text' => 'Khoá', 'color' => 'danger'],
            ];
            $form->switch('status', 'Trạng thái')->states($states)->default(User::ACTIVE);
        })
        ->tab('Thông tin công ty', function ($form) {
            $form->text('profile.company_name', 'Tên công ty')->rules('required');
            $form->text('profile.email', 'Email công ty')->rules('required|email');
            $form->text('profile.address', 'Địa chỉ')->rules('required');
            $form->text('profile.mobile_phone', 'Điện thoại liên hệ')->rules('required');
            $form->hidden('profile.code');
        });
//        ->tab('Thanh toán', function ($form) {
//            $form->text('profile.discount_percent', '% giảm giá đơn hàng')->rules('required');
//            $form->text('profile.min_deposite_percent', '% tối thiểu đặt cọc đơn hàng')->rules('required|email');
//        });

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });

        $form->saved(function (Form $form) {
            $customer_id = $form->model()->id;
            $code = 'MKH-'.str_pad($customer_id, 4, 0, STR_PAD_LEFT);
            UserProfile::whereUserId($customer_id)->update(['code'  =>  $code]);
        });

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        return $form;
    }
}
