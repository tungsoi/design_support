<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\ConfirmDeposite;
use App\Admin\Extensions\BtnDelete;
use App\Admin\Extensions\ExcelExporter;
use App\Admin\Extensions\ModalAction;
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
use function foo\func;
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
        $grid->column('order_number', 'Ma don hang')->display(function () {
            return $this->orderNumber();
        });
        $grid->column('user_id', 'Khách hàng')->display(function (){
            return $this->user->profile->company_name  ?? null;
        });
        $grid->column('total_item_amount', 'Tổng tiền')->display(function (){
            return number_format($this->total_item_amount);
        });
        $grid->column('deposit_default', 'Tien coc mac dinh')->display(function (){
            return number_format($this->total_item_amount * 0.7);
        });
        $grid->column('deposit', 'da Coc')->display(function () {
            $html = number_format($this->deposit) . " (VND)";
            $html .= "<br>" . ($this->deposited_at != null ? date('H:i | d-m-Y', strtotime($this->deposited_at)) : "");

            return $html;
        });
        $grid->column('owed', 'Con lai');
        $grid->column('user_id_created', 'Người tạo đơn')->display(function (){
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
            $route = '/admin/orders/updateStatus';
            $actions->disableDelete();
            if ($this->row->status == 1){
//                $actions->append(new BtnDelete($actions->getKey(), null,'Đặt cọc','fa-dollar','btn-success'));
                $actions->append('<a href="'. route("admin.orders.deposite", $this->row->id) .'" class="btn btn-sm btn-success" data-toggle="tooltip" title="Đặt cọc"><i class="fa fa-dollar" aria-hidden="true"></i></a>');
            }elseif ($this->row->status == 2){

                $actions->append(new BtnDelete($actions->getKey(),$route, 'Xác nhận đặt hàng','fa-check','btn-info',3));
//                $actions->append('<a href="'. route('admin.orders.index') .'" class="btn btn-sm btn-info" data-toggle="tooltip" title="Xac nhan da dat hang"><i class="fa fa-check" aria-hidden="true"></i> </a>');
            }elseif ($this->row->status == 3){
                $actions->append(new BtnDelete($actions->getKey(), $route,'Xác nhận thành công','fa-info-circle','btn-danger',4));
//                $actions->append('<a href="'. route('admin.orders.index') .'" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Xac nhan thanh cong"><i class="fa fa-times" aria-hidden="true"></i></a>');
            }else{
                $actions->append(new BtnDelete($actions->getKey(), $route,'Xác nhận xoá đơn hàng','fa-trash','btn-danger',5));
            }

        });


//        $grid->tools(function (Grid\Tools $tools) {
//            $tools->add(new ModalAction());
//        });
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
//        dd('ok');die();
        $data = $request->only(['id', 'status','product_id', 'deposite', 'total_item_amount', 'discount_amount', 'discount_reason', 'other_amount', 'final_amount', 'is_discount', 'is_bonus', 'deposit', 'user_id_created']);
        $order = Order::create($data);

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
                    'product_property_id' => $data['product_property_id'] ? $data['product_property_id'][$i] : null,
                    'order_qty' => $data['order_qty'][$i],
                    'price' => $data['price'][$i],
                ]);
                $item->save();
            }

        }
        return redirect(route('admin.orders.show',$id));
    }

    public function deposite($id, Content $content) {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->formDeposite($id));
    }

    public function formDeposite($id) {
        $order = Order::find($id);
        $form = new Form(new Order());

        $form->setAction(route('admin.orders.submitDeposite'));
        $form->display('order_number')->default(
            $order->orderNumber()
        );

        $form->display('final_amount', 'Tổng tiền')->default(number_format($order->final_amount));
        $form->display('deposite_default', 'Tổng tiền cọc')->default(number_format($order->total_item_amount * 0.7))
            ->help('70% tong gia tri san pham'); // tien coc mac dinh theo tat ca cac don

        $form->currency('deposit', 'Tiền cọc')->symbol('VND')->digits(0)->required(); // tien khach hang chuyen khoan de vao coc
        $form->hidden('user_id_deposited')->default(Admin::user()->id);
        $form->hidden('deposited_at')->default(now());
        $form->hidden('id_order')->default($id);
//        $form->hidden('status')->default(3);
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        return $form;
    }

    public function submitDeposite(Request $request) {
//        $data = $request->only(['deposit', 'user_id_deposited','status']);
        $order = Order::find($request->id_order);
        if ($order){
            $order->status = 2;
            $order->deposited_at = $request->deposited_at;
            $order->deposit =  $request->deposit;
            $order->user_id_deposited =  $request->user_id_deposited;
            $order->save();
        };
        return redirect(route('admin.orders.index'));
    }

    public function updateStatus(Request $request){
//        dd('ppp');
        try{
            $order = Order::find($request->id);

            if ($order){
                $order->status = $request->status;
                $order->save();
            };
            return [
                'code' => 200
            ];

        }catch (\Exception $e){
            return [
                'code' => 500
            ];
        }


    }
}
