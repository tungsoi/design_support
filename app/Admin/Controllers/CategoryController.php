<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

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
        $grid->name('Tên danh mục')->editable();
        $grid->code('Mã danh mục')->editable();
        $grid->parent_id('Danh mục quản lý')->display(function ()
        {
            if ($this->parent_id == null) {
                return "";
            } else {
                if ($this->parent->parent_id == null) {
                    return $this->parent->name;
                } else {
                    return $this->parent->parent->name . " / " . $this->parent->name ;
                }
            }
        })->label();
//        $grid->column('items', 'Danh mục con')->display(function ()
//        {
//            return Category::whereParentId($this->id)->pluck('name');
//        })->label();
        $grid->products('Số sản phẩm')->display(function () {
            return $this->products->count();
        });

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

        $categorys = Category::all();

        $arr_category = [];
        foreach ($categorys as $category) {
            if ($category->parent_id == null) {
                $arr_category[$category->id] = $category->name;
            } else {
                if ($category->parent->parent_id == null) {
                    $arr_category[$category->id] = $category->parent->name . " / " . $category->name;
                } else {
                    $arr_category[$category->id] = $category->parent->parent->name . " / " . $category->parent->name . " / " . $category->name;
                }

            }
        }
        $form->select('parent_id', 'Danh mục quản lý')->options($arr_category);
        $form->text('name', 'Tên danh mục')->rules('required');
        $form->image('avatar', 'Ảnh đại diện')
        ->thumbnail('small', $width = 100, $height = 100);
//
//        $states = [
//            'on'  => ['value' => 1, 'text' => 'Mở', 'color' => 'success'],
//            'off' => ['value' => 0, 'text' => 'Khoá', 'color' => 'danger'],
//        ];
//        $form->switch('is_show_shop', 'Hiển thị trên trang chủ')->states($states);
        $form->text('code', 'Mã danh mục')->rules('required');

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            // $tools->disableList();
        });

        return $form;
    }
}
