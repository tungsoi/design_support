<?php

namespace App\Admin\Extensions;
use App\Admin\Support\Common;
class MYExcel
{
    public static function getLogo($sheet, $data = [])
    {
        if ($sheet && isset($data['cell'])) {
            $objDrawing = new \PHPExcel_Worksheet_Drawing;
            if (isset($data['file_path'])) {
                $objDrawing->setPath($data['file_path']);
            } else {
                $objDrawing->setPath(public_path('assets/img/logo-design.png'));
            }
            if (isset($data['file_path'])) {
                $objDrawing->setPath($data['file_path']);
            } else {
                $objDrawing->setPath(public_path('assets/img/logo-design.png'));
            }
            $objDrawing->setCoordinates($data['cell']);
            if (isset($data['width'])) {
                $objDrawing->setWidth($data['width']);
            } else {
                $objDrawing->setWidth(250);
            }
            if (isset($data['height'])) {
                $objDrawing->setHeight($data['height']);
            } else {
                $objDrawing->setHeight(50);
            }
            $objDrawing->setWorksheet($sheet);
        }
        return $sheet;
    }

    public static function getHeading($sheet, $data = [])
    {
        if ($data) {
            if (isset($data['cell']) && isset($data['cell_merge'])) {
                $sheet->mergeCells($data['cell'] . ':' . $data['cell_merge']);
            }
            if (isset($data['cell'])) {
                $sheet->cell($data['cell'], function ($cell) use ($data) {
                    if (isset($data['data_text_value']) && $data['data_text_value']) {
                        $objRichText = MYExcel::getRichText($data['data_text_value']);
                        $cell->setValue($objRichText);
                    }
                    if (isset($data['align']) && $data['align'] != '') {
                        $cell->setAlignment($data['align']);
                    }
                    if (isset($data['valign']) && $data['valign'] != '') {
                        $cell->setValignment($data['valign']);
                    }
                    if (isset($data['font_data']) && $data['font_data']) {
                        $cell->setFont(MYExcel::getFont($data['font_data']));
                    } else {
                        $cell->setFont(MYExcel::getFont());
                    }
                });
                if (isset($data['wrap_text']) && $data['wrap_text']) {
                    $sheet->getStyle($data['cell'])->getAlignment()->setWrapText(true);
                }
            }
        }
        return $sheet;
    }

    public static function getFont($data = [])
    {
        $font = [
            'name' => 'Times New Roman',
            'size' => 13,
            'bold' => false,
            'italic' => false,
        ];
        if ($data) {
            if (isset($data['name'])) {
                $font['name'] = $data['name'];
            }
            if (isset($data['size'])) {
                $font['size'] = $data['size'];
            }
            if (isset($data['bold'])) {
                $font['bold'] = $data['bold'];
            }
            if (isset($data['italic'])) {
                $font['italic'] = $data['italic'];
            }
        }
        return $font;
    }

    public static function getRichText($data)
    {
        $objRichText = new \PHPExcel_RichText;
        if ($data) {
            foreach ($data as $item) {
                if (isset($item['text']) && $item['text'] != '') {
                    $objPayable1 = $objRichText->createTextRun($item['text']);
                    if (isset($item['name']) && $item['name'] != '') {
                        $objPayable1->getFont()->setName($item['name']);
                    } else {
                        $objPayable1->getFont()->setName('Times New Roman');
                    }
                    if (isset($item['size']) && $item['size'] != '') {
                        $objPayable1->getFont()->setSize($item['size']);
                    } else {
                        $objPayable1->getFont()->setSize(13);
                    }
                    if (isset($item['italic']) && $item['italic']) {
                        $objPayable1->getFont()->setItalic(true);
                    } else {
                        $objPayable1->getFont()->setItalic(false);
                    }
                    if (isset($item['bold']) && $item['bold']) {
                        $objPayable1->getFont()->setBold(true);
                    } else {
                        $objPayable1->getFont()->setBold(false);
                    }
                }
            }
        }

        return $objRichText;
    }

}
