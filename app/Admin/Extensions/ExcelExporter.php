<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

class ExcelExporter extends AbstractExporter
{
    public function export()
    {
        Excel::create('Filename', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {
                $rows = collect($this->getData())->map(function ($item) {
                    return Arr::only($item, ['id','created_at']);
                });

                $sheet->rows($rows);
            });
        })->export('xlsx');

    }


}