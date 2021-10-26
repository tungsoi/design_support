<?php

Namespace App\Admin\Extensions;

Use Encore\Admin\Grid\Exporters\ExcelExporter;

class PostsExporter extends ExcelExporter
{
    protected $fileName = 'Article list.xlsx';

    protected $columns = [
        'id' => 'ID',
    ];
}