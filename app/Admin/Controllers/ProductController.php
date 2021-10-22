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
use Encore\Admin\Admin as EncoreAdmin;
use Illuminate\Support\Str;


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
        $grid->column('avatar', 'Ảnh đại diện')->display(function () {
            $array = $this->pictures;

            try {
                if ($array != null && sizeof($array) > 0)
                {
                    $data = [];
                    $data[] = isset($array[0]) ? $array[0] : $array[1];

                    return $data;
                }

                return null;
            } catch (\Exception $e) {
                return null;
            }

        })->lightbox(['width' => 80, 'height' => 50]);
        $grid->column('pictures', 'Ảnh sản phẩm')->display(function () {
            $array = $this->pictures;

            if ($array != null && sizeof($array) > 0)
            {
                unset($array[0]);

                return $array;
            }
        })->lightbox(['width' => 80, 'height' => 50]);
        $grid->category_id('Danh mục sản phẩm')->display(function () {
            $category = $this->category;

            if ($category->parent_id == null) {
                return $category->name;
            } else {
                if ($category->parent->parent_id == null) {
                    return $category->parent->name . " / " . $category->name;
                } else {
                    return $category->parent->parent->name . " / " . $category->parent->name . " / " . $category->name;
                }
            }
        })->label();
        $grid->supplier()->name('Nhà cung cấp');
        $grid->link_3d('Link 3D')->display(function () {
            return "<a href=".$this->link_3d.">Xem</a>";
        });
        $grid->link_order('Link mua hàng')->display(function () {
            return "<a href=".$this->link_order.">Xem</a>";
        });
        $grid->option_count('Số Options')->display(function () {
            return $this->properties->count();
        });
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
        $form->column(2/3, function ($form) {
            $form->hidden('code');
            $form->multipleFile('pictures', 'Ảnh')
            ->rules('mimes:jpeg,png,jpg')
            ->help('Ảnh đầu tiên sẽ hiển thị là ảnh đại diện')
            ->removable();

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
            $form->select('category_id', 'Danh mục')
            ->options($arr_category);

            $form->text('name', 'Tên sản phẩm');

            $form->select('supplier_id', 'Nhà cung cấp')
            ->options(Supplier::all()->pluck('name', 'id'));

            $form->url('link_3d', 'Link sản phẩm 3D');
            $form->url('link_order', 'Link mua hàng');

            $form->summernote('description', 'Mô tả sản phẩm');
        });

        $form->column(1/3, function ($form) {
            $form->divider('Kích thước và giá');
            $form->hasMany('properties', "-", function (Form\NestedForm $form) {
                $form->text('size', 'Mã kích thước')->help('Dài x Rộng x Cao');
                $form->select('material_id', 'Vật liệu')->options(Material::all()->pluck('title', 'id'));
                $form->currency('price', 'Giá tiền')->digits(0)->width(200)->symbol('VND');
            });
        });

        $form->saved(function (Form $form) {

            $count = Product::where('category_id', $form->model()->category_id)->where('id', '<=', $form->model()->id)->count();
            $category = Category::find($form->model()->category_id)->code;
            $code = Str::upper($category) ."-". str_pad($count, 4, "0", STR_PAD_LEFT);

            Product::find($form->model()->id)->update([
                'code'  =>  $code
            ]);
        });

        // $form->saving(function (Form $form) {
        //     if ($form->category_id != null) {
        //         $category = Category::find($form->category_id)->name;
        //         $category_code = Str::upper(str_replace("-", '', Str::slug($category)));
        //         $form->code = $category_code."-".str_pad((string) Product::count(), 4, "0", STR_PAD_LEFT);
        //     }
        //     else {
        //         $form->code = "SP-".str_pad((string) Product::count(), 4, "0", STR_PAD_LEFT);
        //     }

        // });

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
        $product = Product::find($request->data);

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
                                . ($option->material->title ?? null)
                                ." - "
                                .number_format($option->price)." VND"
                ]);
            }

            return $option_data;
        }

        return null;
    }

    public function getInfoProduct(Request $request){
        $product = Product::find($request->data);

        $data = [];

        if ($product) {
            $properties = $product->properties;
            foreach ($properties as $option)
            {
                if (! $properties)
                {
                    return null;
                }

                $data['property'][] = collect([
                    'id'    =>  $option->id,
                    'text'  =>  "Size: ".$option->size." (".$option->lenght." x ".$option->width." x ".$option->height.")  - "
                        . ($option->material->title ?? null)
                        ." - "
                        .number_format($option->price)." VND",
                    'price' => $option->price
                ]);
            }

            $pictures = $product->pictures;
            if ($pictures) {
                foreach ($pictures as $picture){
                    $data['pictures'][] = [
                        'asset' => $picture,
                        'link' => asset('uploads/'.$picture)
                    ];
                }
            }
            return $data;
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

    public function getPicture(Request $request){
        $product_pciture = Product::find($request->data)->pictures;
        if ($product_pciture) {
            foreach ($product_pciture as $picture){
                $pictures[] = [
                    'asset' => $picture,
                    'link' => asset('uploads/'.$picture)
                ];
            }
            return  $pictures;
        }
        return null;
    }
}
