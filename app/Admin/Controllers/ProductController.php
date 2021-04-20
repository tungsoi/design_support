<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductProperty;
use App\Models\Supplier;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Http\Request;
Use Encore\Admin\Admin as EncoreAdmin;


class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "";

    public function __construct()
    {
        $this->title = Menu::whereUri('/products')->first()->title;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());
        $grid->model()->orderBy('id', 'desc');

        $grid->expandFilter();
        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/3, function ($filter) {
                $filter->like('code', 'Mã sản phẩm');
            });
            $filter->column(1/3, function ($filter) {
                $filter->like('name', 'Tên sản phẩm');
            });
            $filter->column(1/3, function ($filter) {
                $filter->equal('category_id', 'Danh mục sản phẩm')
                    ->select(Category::all()->pluck('name', 'id'));
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');
        $grid->code('Mã sản phẩm');
        $grid->name('Tên sản phẩm');
        $grid->column('avatar', 'Ảnh đại diện')->lightbox(['width' => 80, 'height' => 50]);
        $grid->column('pictures', 'Ảnh sản phẩm')->lightbox(['width' => 80, 'height' => 50]);
        $grid->category()->name('Danh mục sản phẩm');
        $grid->supplier()->name('Nhà cung cấp');
        $grid->link_3d('Link 3D')->display(function () {
            return "<a href='.$this->link_3d.'>Xem</a>";
        });
        $grid->option_count('Số Options')->display(function () {
            return $this->properties->count();
        });
        $grid->color_count('Màu sắc')->display(function () {
            return $this->colors->pluck('color');
        })->label();
        $grid->quantity_sold('Số lượng đã bán');
        $grid->disableColumnSelector();
        $grid->disableBatchActions();
        $grid->paginate(10);

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
        $show = new Show(Product::findOrFail($id));

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
        $form = new Form(new Product);
        $form->tab('Thông tin sản phẩm', function ($form) {
            $form->image('avatar', 'Ảnh đại diện')
            ->thumbnail('small', $width = 50, $height = 50)
            ->rules('required');

            $form->multipleFile('pictures', 'Ảnh mô tả sản phẩm')
            ->rules('mimes:jpeg,png,jpg');

            $form->select('category_id', 'Danh mục sản phẩm')
            ->options(Category::all()->pluck('name', 'id'))
            ->rules('required');

            $form->text('code', 'Mã sản phẩm')
                ->rules('required')->help('VD: GHE001');

            $form->text('name', 'Tên sản phẩm')
                ->rules('required')->help('VD: Ghế Sofa Luxury');

            $form->summernote('description', 'Mô tả sản phẩm')->rules('required');

            $form->select('supplier_id', 'Nhà cung cấp')
            ->options(Supplier::all()->pluck('name', 'id'))
            ->rules('required');

            $form->url('link_3d', 'Link sản phẩm 3D');
        })
        ->tab('Kích cỡ và giá', function ($form) {

            $form->hasMany('properties', "-", function (Form\NestedForm $form) {
                $form->text('size', 'Mã kích thước')->rules('required');
                $form->select('material_id', 'Vật liệu')->options(Material::all()->pluck('title', 'id'))->rules('required');
                $form->currency('price', 'Giá tiền')->digits(0)->width(200)->symbol('VND')->rules('required');
                $form->text('lenght', 'Chiều dài (cm)')->rules('required');
                $form->text('width', 'Chiều rộng (cm)')->rules('required');
                $form->text('height', 'Chiều cao (cm)')->rules('required');
            });

        })
        ->tab('Màu sắc', function ($form) {

            $form->hasMany('colors', "-", function (Form\NestedForm $form) {
                $form->text('color', 'Tên màu sắc')->rules('required');
            });

        });

        $form->confirm('Xác nhận lưu dữ liệu ?');

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        return $form;
    }

    public function getProperty(Request $request)
    {
        $product = Product::find($request->get('q'));

        if ($product) {
            $options = $product->properties;

            $option_data = [];
            foreach ($options as $option)
            {
                if (! $options)
                {
                    return null;
                }

                $option_data[] = collect([
                    'id'    =>  $option->id,
                    'text'  =>  "Size: ".$option->size." (".$option->lenght." x ".$option->width." x ".$option->height.")  - "
                                . $option->material->title
                                ." - "
                                .number_format($option->price)." VND"
                ]);
            }
            return $option_data;
        }

        return null;
    }

    public function getColor(Request $request)
    {
        $product = Product::find($request->get('q'));

        if ($product) {
            $options = $product->colors;
            if (! $options)
            {
                return null;
            }

            $option_data = [];
            foreach ($options as $option)
            {
                $option_data[] = collect([
                    'id'    =>  $option->id,
                    'text'  =>  $option->color
                ]);
            }
            return $option_data;
        }

        return null;
    }

    public function getPrice(Request $request)
    {
        $product = Product::find($request->get('q'));

        if ($product) {
            $options = $product->properties;
            if (! $options)
            {
                return null;
            }

            $option_data = [];
            foreach ($options as $option)
            {
                $option_data[] = collect([
                    'id'    =>  $option->id,
                    'text'  =>  number_format($option->price)." VND"
                ]);
            }
            return $option_data;
        }

        return null;
    }

    public function getPriceFromProperty(Request $request)
    {
        $product_property = ProductProperty::find($request->get('q'));

        if ($product_property) {
            return [
                collect([
                    'id'    =>  $product_property->price,
                    'text'  =>  number_format($product_property->price)." VND"
                ])
            ];
        }

        return null;
    }
}
