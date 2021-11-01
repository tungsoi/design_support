<?php

namespace App\Admin\Extensions;

use App\Models\OrderItem;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExporterDetailOrder extends AbstractExporter
{
    public function export()
    {
        dd('cc');
        Excel::create('Chi tiết đơn', function($excel) {
            dd('ccs');die();
            $excel->sheet('Sheetname', function($sheet) {
                $rows = collect($this->getData())->map(function ($item) {

                    return $item;
                });
                $data = [];
                $data[] = $this->header();
                $key = 1;
                foreach ($rows->toArray() as $row) {
                    dd($row);die();
                    $order = OrderItem::find($row['id']);
                    $customer = $order->user->username ?? null;
//                    $product = User::find($row['user_id'])->username;
                    $total_amount = $order->total_item_amount ? number_format($order->total_item_amount) : 0;
                    $total_deposite = $order->deposite ? number_format($order->deposite) : 0;
                    $user_id_created = $order->userCreate->username ?? null;
                    $status = $order->statusText ? $order->statusText->title : '';
                    $created_at = $order->created_at ? date('H:i | d-m-Y', strtotime($order->created_at)) : null;
                    $data[] = [
                        $key++,
                        $customer,
                        $total_amount,
                        $total_deposite,
                        $status,
                        $user_id_created,
                        $created_at
                    ];
                }
                $sheet->rows($data);
            });
        })->export('xlsx');

    }

    public function header()
    {
        return ['STT','KHÁCH HÀNG','TỔNG TIỀN (VND)','ĐÃ CỌC (VND)','TRẠNG THÁI	','NGƯỜI TẠO ĐƠN','THỜI GIAN TẠO'];
    }

//'SẢN PHẨM',
}