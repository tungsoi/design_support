<?php

namespace App\Admin\Support;

use Carbon\Carbon;

class Common
{
    public static function convertWeekDay($date){
        $weekMap = [
            0 => 'Chủ nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];
        // $dayOfTheWeek = date('w', strtotime($date));
        // dd($dayOfTheWeek);
        $weekday = $weekMap[$date] ?? null;
        return $weekday;
    }
}
