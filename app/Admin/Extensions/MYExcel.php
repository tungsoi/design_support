<?php

namespace App\Admin\Extensions;

use App\Admin\Support\Common;
use PHPExcel_Style;
use PHPExcel_Style_Alignment;

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

    public static function getHeaderTable($sheet, $column_Table, $row_Table, $textColmn_Table)
    {
        foreach ($column_Table as $key => $item) {

            if (strlen($item) > 1) {
                $itemColumn = explode(' ', $item);
                $sheet->mergeCells($itemColumn[0] . $row_Table . ':' . $itemColumn[1] . $row_Table);
                $sheet->setCellValue($itemColumn[0] . $row_Table, $textColmn_Table[$key]);
                $style = array(
                    'alignment' => array(
                        'horizontal' =>  PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $sheet->getStyle($itemColumn[0] . $row_Table . ':' . $itemColumn[1] . $row_Table)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
                $sheet->getStyle($itemColumn[0] . $row_Table . ':' . $itemColumn[1] . $row_Table)->applyFromArray($style);
            } else {
                $sheet->cell($item . $row_Table, function ($cell) use ($textColmn_Table, $key) {
                    if (isset($textColmn_Table[$key])) {
                        $cell->setValue($textColmn_Table[$key]);
                    } else {
                        $cell->setValue(null);
                    }
                    if (isset($alignment)) {
                        $cell->setAlignment($alignment[$key]);
                    } else {
                        $cell->setAlignment('center');
                    }

                    if (isset($valignment)) {
                        $cell->setValignment($valignment[$key]);
                    } else {
                        $cell->setValignment('center');
                    }
                    $cell->setFont(MYExcel::getFont());
                });
                $sheet->getStyle($item . $row_Table)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
            }
        }
        // die();
        return $sheet;
    }

    public static function header($sheet, $title)
    {
        $sheet->setWidth(array(
            'A' => 15,
            'B' => 15,
            'C' => 20,
            'D' => 15,
            'E' => 17,
            'F' => 15,
            'G' => 17,
            'H' => 17,
            'I' => 17,
            'J' => 17,
            'K' => 17,
            'L' => 17,
            'M' => 17,
            'N' => 17,
            'O' => 17,
        ));
        $sheet->getRowDimension(2)->setRowHeight(19);
        $sheet = MYExcel::getLogo($sheet, ['cell' => 'A2']);

        $cell_heading_D2 = [
            'cell' => 'C2',
            'cell_merge' => 'G2',
            'data_text_value' => [
                [
                    'text' => 'CÔNG TY TNHH PHÁT TRIỂN THƯƠNG MẠI DỊCH VỤ LONG HẢI',
                    'bold' => true,
                    'size' => 12,
                ],
            ],
            'align' => 'center',
        ];
        $sheet = MYExcel::getHeading($sheet, $cell_heading_D2);

        $sheet->getRowDimension(3)->setRowHeight(17);
        $cell_heading_D3 = [
            'cell' => 'C3',
            'cell_merge' => 'G3',
            'data_text_value' => [
                [
                    'text' => 'Địa chỉ : 521 Minh Khai Phường Vĩnh Tuy Quận Hai Bà Trưng TP Hà Nội',
                    'size' => 12,
                ],
            ],
            'align' => 'center',
        ];
        $sheet = MYExcel::getHeading($sheet, $cell_heading_D3);
        $sheet->getRowDimension(4)->setRowHeight(17);
        $cell_heading_D4 = [
            'cell' => 'C4',
            'cell_merge' => 'G4',
            'data_text_value' => [
                [
                    'text' => 'MST : 0109534169 - SĐT 0703552222  - Web: supportdesign.vn  -  Email',
                    'size' => 12,
                    'italic' => true,
                ],
            ],
            'align' => 'center',
        ];
        $sheet = MYExcel::getHeading($sheet, $cell_heading_D4);

        $sheet->getRowDimension(10)->setRowHeight(24);
        $cell_heading_B10 = [
            'cell' => 'C7',
            'cell_merge' => 'E7',
            'data_text_value' => [
                [
                    'text' => $title,
                    'bold' => 500,
                    'size' => 16,
                ],
            ],
            'font_data' => [
                'bold' => true,
                'size' => 16,
            ],
            'align' => 'center',
            'valign' => 'center',
        ];
        $sheet = MYExcel::getHeading($sheet, $cell_heading_B10);
        $sheet->getRowDimension(11)->setRowHeight(24);
        $date = getdate();
        $wday = Common::convertWeekDay($date['wday']) ?? null;

        $cell_heading_B11 = [
            'cell' => 'F9',
            'cell_merge' => 'H9',
            'data_text_value' => [
                [
                    'text' => $wday . ', ngày ' . $date['mday'] . ', tháng ' . $date['mon'] . ', năm ' .   $date['year'],
                ],
            ],
            'font_data' => [
                'size' => 14,
            ],
        ];
        $sheet = MYExcel::getHeading($sheet, $cell_heading_B11);
        $sheet->getRowDimension(12)->setRowHeight(24);
        return $sheet;
    }
}
