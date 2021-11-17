<?php

namespace App\Admin\Support;

use Carbon\Carbon;

class Common
{
    public static function convertWeekDay($date)
    {
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

    public static function dochangchuc($so, $daydu)
    {
        $mangso = array(
            'không',
            'một',
            'hai',
            'ba',
            'bốn',
            'năm',
            'sáu',
            'bảy',
            'tám',
            'chín'
        );
        $chuoi  = "";
        $chuc   = floor($so / 10);
        $donvi  = $so % 10;
        if ($chuc > 1) {
            $chuoi = " " . $mangso[$chuc] . " mươi";
            if ($donvi == 1) {
                $chuoi .= " mốt";
            }
        } elseif ($chuc == 1) {
            $chuoi = " mười";
            if ($donvi == 1) {
                $chuoi .= " một";
            }
        } elseif ($daydu && $donvi > 0) {
            $chuoi = " lẻ";
        }
        if ($donvi == 5 && $chuc > 1) {
            $chuoi .= " lăm";
        } elseif ($donvi > 1 || ($donvi == 1 && $chuc == 0)) {
            $chuoi .= " " . $mangso[$donvi];
        }
        return $chuoi;
    }

    public static function docblock($so, $daydu)
    {
        $mangso = array(
            'không',
            'một',
            'hai',
            'ba',
            'bốn',
            'năm',
            'sáu',
            'bảy',
            'tám',
            'chín'
        );
        $chuoi  = "";
        $tram   = floor($so / 100);
        $so     = $so % 100;
        if ($daydu || $tram > 0) {
            $chuoi = " " . $mangso[$tram] . " trăm";
            $chuoi .= self::dochangchuc($so, true);
        } else {
            $chuoi = self::dochangchuc($so, false);
        }
        return $chuoi;
    }

    public static function dochangtrieu($so, $daydu)
    {

        $chuoi = "";
        $trieu = floor($so / 1000000);
        $so    = $so % 1000000;
        if ($trieu > 0) {
            $chuoi = self::docblock($trieu, $daydu) . " triệu";
            $daydu = true;
        }
        $nghin = floor($so / 1000);
        $so    = $so % 1000;
        if ($nghin > 0) {
            $chuoi .= self::docblock($nghin, $daydu) . " nghìn";
            $daydu = true;
        }
        if ($so > 0) {
            $chuoi .= self::docblock($so, $daydu);
        }
        return $chuoi;
    }


    public static function docso($so)
    {
        $mangso = array(
            'không',
            'một',
            'hai',
            'ba',
            'bốn',
            'năm',
            'sáu',
            'bảy',
            'tám',
            'chín'
        );
        if ($so == 0)
            return ucfirst(trim($mangso[0]));
        $chuoi = "";
        $hauto = "";
        do {
            $ty = $so % 1000000000;
            $so = floor($so / 1000000000);
            if ($so > 0) {
                $chuoi = self::dochangtrieu($ty, true) . $hauto . $chuoi;
            } else {
                $chuoi = self::dochangtrieu($ty, false) . $hauto . $chuoi;
            }
            $hauto = " tỷ";
        } while ($so > 0);
        return ucfirst(trim($chuoi));
    }
}
