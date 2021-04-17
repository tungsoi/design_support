<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Supplier;

class SupplierController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Nhà cung cấp';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Supplier);
        $grid->model()->orderBy('id', 'desc');

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
        $grid->name('Tên nhà cung cấp');
        $grid->description('Mô tả thông tin');
        $grid->address('Địa chỉ liên lạc');
        $grid->mobile_phone('Số điện thoại');
        $grid->column('created_at', 'Ngày tạo');

        $grid->disableBatchActions();

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
        $show = new Show(Supplier::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', 'Tên nhà cung cấp');
        $show->field('description', 'Mô tả thông tin');
        $show->field('address', 'Địa chỉ liên lạc');
        $show->field('mobile_phone', 'Số điện thoại');
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
        $form = new Form(new Supplier);

        $form->text('name', 'Tên nhà cung cấp')->rules('required');
        $form->text('description', 'Mô tả thông tin')->rules('required');
        $form->text('address', 'Địa chỉ liên lạc')->rules('required');
        $form->text('mobile_phone', 'Số điện thoại')->rules('required');
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
