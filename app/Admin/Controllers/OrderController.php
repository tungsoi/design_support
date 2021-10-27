<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ExcelExporter;
use App\Admin\Extensions\PostsExporter;
use App\Models\ProductProperty;
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
        $grid->exporter(new ExcelExporter());
//        $grid->export(function ($export) {
//
//            $export->filename('Filename.csv');
//
//            $export->except(['user_id']);
//
//            $export->only(['user_id']);
//
//            $export->originalValue(['user_id']);
//
//            $export->column('user_id', function ($value, $original) {
//                return $value;
//            )};
//        });
//        $grid->exporter(new PostsExporter());

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number+1));
        });
        $grid->column('number', 'STT');
        $grid->column('user_id', 'Khách hàng')->display(function (){
            return $this->user->profile->company_name  ?? null;
        });
        $grid->column('total_item_amount', 'Tổng tiền')->display(function (){
            return number_format($this->total_item_amount);
        });
        $grid->column('deposit', 'Tổng cọc')->display(function (){
            return number_format($this->deposit);
        });
        $grid->column('owed', 'Con lai');
//        $grid->column('number', 'Thời gian cọc');
        $grid->column('user_create', 'Người tạo đơn')->display(function (){
            return $this->userCreate->username ?? null;
        });
        $grid->column('status', 'Trạng thái')->display(function (){
            $html = $this->statusText->title;
            $label = $this->statusText->label;

            return "<span class='label label-".$label."'>".$html."</span>";
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
//            $actions->disableEdit();
            $route = route("admin.orders.test");
            $actions->append('<a href=" '. $route .' " ><i class="fa fa-credit-card" aria-hidden="true"></i></a>');
        });
        return $grid;
    }
    /*
     * detail
     */

    public function show($id, Content $content)
    {
        return $content->header(trans($this->title))->description('Chi tiết')->row(function (Row $row) use ($id) {
            $row->column(12, $this->detail($id)); // thong tin don hang
            $row->column(12, $this->showOrderProperty($id)); // thong tin san pham -> chon theo table
        });
    }

    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->user_id('Tên khách hàng')->as(function(){
            return $this->user->profile->company_name;
        });

        $show->status('Trạng thái')->as(function(){
            return $this->statux == 1 ? 'N/A' : 'Đơn mới ';
        });

        $show->total_item_amount('Tổng tiền')->as(function(){
            return number_format($this->total_item_amount);
        });

        $show->deposit('Tổng cọc')->as(function(){
            return number_format($this->deposit);
        });

        $show->user_create('Người tạo đơn ')->as(function(){
            return $this->userCreate->username ?? null ;
        });



        $show->created_at();

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
//                $tools->disableList();
                $tools->disableDelete();
            });;
        return $show;
    }

    protected function showOrderProperty($id){
        return OrderItem::grid(function (Grid $grid) use ($id){

            $grid->model()->where('order_id', $id);
            $key = 1;
            $grid->setTitle('Chi tiết sản phẩm');
            $grid->key('STT')->display(function () use ($key){
               return $key ++;
            });
            $grid->product_id('Sản phẩm')->display(function (){
                return $this->product->name ?? null;
            });
            $grid->order_qty('Số lượng đặt mua');
            $grid->product_property_id('Option sản phẩm')->display(function (){
               return $this->productProperty->size ??  null ;
            });
            $grid->price('Giá tiền sản phẩm')->display(function (){
                return $this->productProperty ? number_format($this->productProperty->price ) : null ;
            });
            $grid->amount_one_item('Tổng tiền sản phẩm')->display(function (){
                return number_format($this->amount_one_item )??  null ;
            });

            $grid->picture('Ảnh')->display(function(){
//                dd($this->picture);die();
                $picture = $this->picture  ? asset('uploads/' . $this->picture ) : null;
//                var_dump($picture);
                return "<img style='width: 50px;height: 50px; border-radius: 3px' src='{$picture}' />";
            });

            $grid->disableRowSelector();
            $grid->disableColumnSelector();
            $grid->disableCreateButton();
            $grid->disableFilter();
            $grid->disableActions();
//            $grid->disableExport();
        });
//        $show = new Show(OrderItem::findOrFail($id));
//        dd($show);
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
//
//    public function edit($id, Content $content)
//    {
//        $getID = $this->getId(request()->url());
//        return $this->form($getID);
//    }

    protected function form($id = null)
    {
        $form = new Form(new Order);
//        Admin::style('
//        .col-md-3 .col-sm-2, .col-md-3 .col-sm-8{width:100% !important; text-align: left;}
//        .col-md-3, .col-md-9 {border-right: 1px solid #b3b3b3 !important}
//        .col-md-3 hr, .col-md-9 hr {border-top: 1px solid #b3b3b3;}
//        ');
        $getID = $this->getId(request()->url());
        $form->column(12, function ($form) {
            $form->column(6, function ($form) {
                $customers = User::whereIsCustomer(User::CUSTOMER)->orderBy('id', 'desc')->get();
                $temp_customer = [];
                foreach ($customers as $customer)
                {
                    $temp_customer[$customer->id] = $customer->profile->code . " - " .$customer->profile->company_name;
                }
                $form->select('user_id', 'Khách hàng')->options($temp_customer)->rules('required')->attribute(['class' => 'custom-width']);
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
            });
            $form->column(6, function ($form) {
                $form->display('action.created_datetime', 'Thời gian tạo - Người thực hiện')->default(date('H:i | d-m-Y', strtotime(now())) . " - " .Admin::user()->name)->disable();
                $form->currency('total_item_amount', 'Tổng tiền sản phẩm')
                    ->width(100)
                    ->readonly()
                    ->symbol('VND')
                    ->digits(0)
                    ->attribute(["data_amount" => 0]);
                $form->currency('deposit', 'Tổng tiền cọc')
                    ->width(100)
                    ->readonly()
                    ->symbol('VND')
                    ->digits(0);
            });
//            $form->select('user_id', 'Sản ')->options($temp_customer)->rules('required')->attribute(['class' => 'custom-width']);
        });

        $form->column(12, function ($form) {
            $form->divider();
        });

        $form->column(12, function ($form) use ($getID) {
            $route_get_product = route('admin.products.getInfoProduct');
            $products = Product::orderBy('id', 'desc')->get();
            $oderItem = OrderItem::whereOrderId($getID)->get();
            $productProperty = ProductProperty::all();
            $form->html(view('furns.partials.property_order',[
                'products' => $products,
                'orderItem' => $oderItem,
                'productProperty' => $productProperty,
                'route_get_product' => $route_get_product,
            ]));
//            $form->tools(function (Form\Tools $tools) {
//                $tools->add('<a class="btn btn-add-order btn-sm btn-primary">Thêm sản phẩm</a>');
//            });
        })->setWidth(12, 0);

        $form->hidden('user_create')->default(Auth::user()->id);
        $form->confirm('Xác nhận lưu dữ liệu đơn hàng ?');

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        Admin::js('assets/furn/js/script_design.js');
        Admin::css('assets/furn/css/custom.css');

        return $form;
    }

    public function storeRebuild(Request $request) {
       $order = Order::create($request->all());
        $data = $request->all();
        for ($i = 1; $i < count($data['product_id']); $i++){
            $item = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $data['product_id'][$i],
                'product_property_id' => $data['product_property_id'][$i-1],
                'order_qty' => $data['order_qty'][$i],
                'price' => $data['price'][$i],
            ]);
            $item->save();
        }
        return redirect(route('admin.orders.index'));
    }

    protected function getId($data){
        $remove_http = str_replace('http://', '', $data);

        $val = (explode('/', $remove_http));
        return  $val[3];
    }

    public function updateRebuild($id, Request $request) {
        $orderItem = OrderItem::where('order_id',$id)->get();
        if($orderItem){
            $order = Order::find($id);
            $order->update($request->all());
            foreach ($orderItem as $key => $order){
                $order->delete();
            }
            $data = $request->all();
            for ($i = 1; $i < count($data['product_id']); $i++){
                $item = new OrderItem([
                    'order_id' => $id,
                    'product_id' => $data['product_id'][$i],
                    'product_property_id' => $data['product_property_id'][$i-1],
                    'order_qty' => $data['order_qty'][$i],
                    'price' => $data['price'][$i],
                ]);
                $item->save();
            }

        }
        return redirect(route('admin.orders.show',$id));
    }

    public function updateDeposit(Request $request){
        dd($request->all());
    }
    public function test(){
        dd('o');
    }
}
