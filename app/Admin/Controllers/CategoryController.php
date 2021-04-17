<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "";

    public function __construct()
    {
        $this->title = Menu::whereUri('/categories')->first()->title;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());
        $grid->model()->orderBy('id', 'desc');

        $grid->expandFilter();
        $grid->filter(function($filter){
            $filter->column(1/3, function ($filter) {
                $filter->disableIdFilter();
                $filter->like('name', 'Tên danh mục');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');

        $grid->column('avatar', 'Ảnh đại diện')->lightbox(['width' => 80, 'height' => 50]);
        $grid->name('Tên danh mục');
        $grid->parent_id('Danh mục quản lý')->display(function ()
        {
            return Category::find($this->parent_id)->name ?? "";
        })->label();
        $grid->column('items', 'Danh mục con')->display(function ()
        {
            return Category::whereParentId($this->id)->pluck('name');
        })->label();
        $grid->products('Số sản phẩm')->display(function () {
            return $this->products();
        });

        $grid->is_show_shop('Trang thái')->radio([
            1 => 'Hiển thị',
            0 => 'Không hiển thị'
        ]);


        $grid->disableColumnSelector();
        $grid->paginate(100);

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
        $show = new Show(Category::findOrFail($id));

        $show->parent_id('Danh mục quản lý')->as(function ()
        {
          return Category::find($this->parent_id)->name ?? "";
        });
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
        $form = new Form(new Category);

        $form->select('parent_id', 'Danh mục quản lý')->options(Category::whereNull('parent_id')->pluck('name', 'id'));
        $form->text('name', 'Tên danh mục')->rules('required');
        $form->image('avatar', 'Ảnh đại diện')
        ->thumbnail('small', $width = 100, $height = 100)
        ->rules('required');
        $form->select('is_show_shop', 'Hiển thị trên trang chủ')
        ->options([
            0   =>  'Không hiển thị',
            1   =>  'Hiển thị'
        ]);

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });

        return $form;
    }
}
