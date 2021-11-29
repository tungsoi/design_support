<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\User;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Bảng điều khiển')
            ->row(function (Row $row) {
                if (Admin::user()->isRole('administrator')) {
                    $amount_products_price = Order::get()->sum('amount_products_price');

                    $row->column(3, new InfoBox('Khách hàng', 'book', 'green', '/admin/customers', User::whereIsCustomer(User::CUSTOMER)->count()));
                    $row->column(3, new InfoBox('Đơn hàng', 'users', 'aqua', 'admin/orders', OrderProduct::count()));
                    $row->column(3, new InfoBox('Tổng giá trị đơn hàng', 'tag', 'yellow', '/admin/orders', number_format($amount_products_price)));
                    $row->column(3, new InfoBox('Tổng lợi nhuận', 'tag', 'red', '', '0'));
                } else if (Admin::user()->isRole('customer')) {
                    $products = Order::withCount('products')->where('customer_id', Admin::user()->id)->get();
                    $row->column(6, new InfoBox('Đơn hàng của bạn', 'users', 'aqua', 'admin/orders', $products->count()));
                    $row->column(6, new InfoBox('Tổng giá trị đơn hàng', 'tag', 'yellow', 'admin/orders', number_format($products->sum('amount_products_price'))));
                }
            })
            ->row(function (Row $row) {
                $row->column(9, function (Column $column) {
                    if (Admin::user()->isRole('administrator')) {
                        $column->append(view('admin.chart.chart1')->render());
                    }
                });
            });
    }
}
