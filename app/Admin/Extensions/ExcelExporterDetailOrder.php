<?php

namespace App\Admin\Extensions;

use App\Models\OrderItem;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExporterDetailOrder extends AbstractExporter
{
    public function export()
    {
        $data =  OrderItem::where('order_id',$id)->get();
        Excel::create('Chi tiết đơn', function($excel) use ($data) {
            $excel->sheet('Sheetname', function($sheet) use ($data) {
                $rows = collect($data)->map(function ($item) {

                    return $item;
                });
                $data = [];
                $data[] = $this->header();
                $key = 1;
                foreach ($rows->toArray() as $row) {
                    $order = OrderItem::find($row['id']);
                    $product = Product::find($order->product_id) ? Product::find($order->product_id)->name : null;
                    $productProperty = ProductProperty::find($order->product_property_id) ? ProductProperty::find($order->product_property_id)->size : null;
                    $price = $order->price ? number_format($order->price): null;
                    $order_qty = $order->order_qty ? ($order->order_qty): null;
                    $created_at = $order->created_at ? date('H:i | d-m-Y', strtotime($order->created_at)) : null;
                    $data[] = [
                        $key++,
                        $product,
                        $productProperty,
                        $price,
                        $order_qty,
                        $created_at
                    ];
                }
                $sheet->rows($data);
            });
        })->export('xlsx');

        return redirect(route('admin.orders.index'));

    }

    public function header()
    {
        return ['STT','SẢN PHẨM','OPTION SẢN PHẨM','GIÁ','SỐ LƯỢNG','THỜI GIAN TẠO'];
    }

//'SẢN PHẨM',
}