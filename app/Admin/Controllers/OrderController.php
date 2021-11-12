<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\Cancel;
use App\Admin\Actions\Order\ConfirmOrdered;
use App\Admin\Actions\Order\ConfirmSuccess;
use App\Admin\Actions\Order\Deposite;
use App\Admin\Actions\Order\ExportAmount;
use App\Admin\Actions\Order\ExportPaymentBill;
use App\Admin\Actions\Order\ExportShipBill;
use App\Admin\Extensions\MYExcel;
use App\Admin\Service\PortalService;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductStatus;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Danh sách đơn hàng';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $grid->model()->orderBy('id', 'desc')
            ->with('products')
            ->with('statusText');

        $grid->expandFilter();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1 / 3, function ($filter) {
                $filter->like('id', 'Mã đơn hàng');
            });
        });

        $grid->rows(function (Grid\Row $row) {
            $row->column('number', ($row->number + 1));
        });

        $grid->column('number', 'STT');
        $grid->order_number('Mã đơn hàng')->display(function () {
            return 'NT-' . str_pad($this->id, 4, 0, STR_PAD_LEFT);
        })->label('primary');
        $grid->column('products', 'Sản phẩm')->display(function ($products) {
            return sizeof($products);
        });
        $grid->column('customer_id', 'Khách hàng')->display(function () {
            return $this->customer->profile->company_name ?? "";
        });
        $grid->column('status', 'Trạng thái')->display(function () {
            $color = $this->statusText->color;
            $name = $this->statusText->name;
            return "<span class='label label-{$color}'>{$name}</span>";
        });
        $grid->column('amount_products_price', 'Tổng tiền sản phẩm (VND)');
        $grid->column('amount_ship_service', 'Tổng phí vận chuyển (VND)');
        $grid->column('amount_other_service', 'Tổng phí phát sinh (VND)');
        $grid->column('discount_value', 'Tổng tiền giảm (VND)');
        $grid->column('total_amount', 'Tổng giá cuối (VND)');
        $grid->column('deposited', 'Đã cọc (VND)');
        $grid->column('owed', 'Còn lại (VND)')->display(function () {
            return "-";
        });
        $grid->column('logs', 'Timeline')->display(function () {
            return "-";
        });

        $grid->disableBatchActions();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            // $actions->disableEdit();
            // $actions->disableView();

            $actions->append(new Deposite());
            $actions->append(new Cancel());
            $actions->append(new ConfirmOrdered());
            $actions->append(new ConfirmSuccess());
            $actions->append(new ExportAmount($actions->getKey()));
            $actions->append(new ExportShipBill());
            $actions->append(new ExportPaymentBill());
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        Admin::js('assets/furn/js/order.js');
        $form = new Form(new Order);

        $service = new PortalService();

        $form->column(6, function ($form) use ($service) {
            $form->select('customer_id')->options($service->getListCustomer());
            $form->display('user_action_name')->default(Admin::user()->name);
            $form->display('action_time')->default(now());
        });

        $form->column(6, function ($form) use ($service) {
            $form->currency('amount_products_price')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('default_deposite')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_ship_service')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_other_service')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('discount_value')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('total_amount')->digits(0)->symbol('VND')->readonly()->attribute(['style' => 'width: 100% !important;']);
        });

        $form->column(12, function ($form) use ($service) {

            $form->divider();
            $form->hasMany('products', '- Danh sách sản phẩm', function (Form\NestedForm $form) {
                $form->select('status')->options(OrderProductStatus::pluck('name', 'id'))->default(1)->disable();
                $form->number('quality')->default(1);
                $form->currency('price')->digits(0)->symbol('VND');
                $form->currency('amount')->digits(0)->symbol('VND')->readonly();
                $form->text('link');
                $form->text('description');
                $form->select('payment_type')->options(OrderProductStatus::PAYMENT_TYPE)->default(0);
                $form->currency('value_use_payment')->digits(2)->symbol('KG / M3');
                $form->currency('service_price')->digits(0)->symbol('VND');
                $form->currency('payment_amount')->digits(0)->symbol('VND');
                $form->text('transport_code');
                $form->text('payment_code');
                $form->text('note');
                $form->multipleFile('images', 'Ảnh')
                    ->rules('mimes:jpeg,png,jpg')
                    ->removable();
            });
        });

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        return $form;
    }

    public function exportExcelDetailOrder($id)
    {
        $self = $this;
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $products = OrderProduct::where('order_id', $id)->get();
        Excel::create('ok', function ($excel) use ($self) {
            $excel->sheet('Báo giá sản phẩm', function (LaravelExcelWorksheet $sheet) use ($self) {
                $sheet = $self::header($sheet);
                $sheet->cell('A10', function ($cell) {
                    $cell->setValue('TÊN SP');
                    $cell->setValignment('center');
                });
                $sheet->cell('A11', function ($cell) {
                    $cell->setValue('MÃ SỐ');
                    $cell->setValignment('center');
                });
                $sheet->cell('A13', function ($cell) {
                    $cell->setValue('STT');
                    $cell->setValignment('center');
                });
                $sheet->cell('B13', function ($cell) {
                    $cell->setValue('Tên sản phẩm');
                    $cell->setValignment('center');
                });
                $sheet->cell('C13', function ($cell) {
                    $cell->setValue('Chất liệu chung');
                    $cell->setValignment('center');
                });
                $sheet->cell('D13', function ($cell) {
                    $cell->setValue('Phân loại');
                    $cell->setValignment('center');
                });
                $sheet->cell('E13', function ($cell) {
                    $cell->setValue('Chỉ định chi tiết');
                    $cell->setValignment('center');
                });
                $sheet->cell('F13', function ($cell) {
                    $cell->setValue('Giá sản phẩm');
                    $cell->setValignment('center');
                });
                $sheet->cell('G13', function ($cell) {
                    $cell->setValue('SL');
                    $cell->setValignment('center');
                });
                $sheet->cell('H13', function ($cell) {
                    $cell->setValue('Thành tiền(VND)');
                    $cell->setValignment('center');
                });

                $row_num = 14;
                for ($i = 0; $i < 9; $i++) {
                    $sheet->cell('A' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('B' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('C' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('D' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('E' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('F' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('G' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $sheet->cell('H' . $row_num, function ($cell) use ($i) {
                        $cell->setValue($i);
                        $cell->setFont(MYExcel::getFont());
                        $cell->setAlignment('center');
                        $cell->setValignment('center');

                    });
                    $row_num++;
                }
                $cell_heading_B14 = [
                    'cell' => 'A' . $row_num,
                    'cell_merge' => 'G' . $row_num,
                    'data_text_value' => [
                        [
                            'text' => 'Tổng cộng',
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                    'valign' => 'center',
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_B14);
                $cell_heading_B15 = [
                    'cell' => 'H' . $row_num,
                    'data_text_value' => [
                        [
                            'text' => '2222',
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                    'valign' => 'center',
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_B15);
                $sheet->getStyle("A13:H" . $row_num)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));

                $cell_heading_B16 = [
                    'cell' => 'A' . ($row_num + 2),
                    'cell_merge' => 'E' . ($row_num + 2),
                    'data_text_value' => [
                        [
                            'text' => 'Báo giá có giá trị trong vòng 30 ngày kể từ ngày làm báo giá',
                            'size' => 12,
                        ],
                    ],

                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_B16);

                $cell_heading_B17 = [
                    'cell' => 'G' . ($row_num + 2),
                    'cell_merge' => 'H' . ($row_num + 2),
                    'data_text_value' => [
                        [
                            'text' => 'NGƯỜI LÀM BÁO GIÁ',
                            'size' => 12,
                        ],
                        'align' => 'center',
                        'valign' => 'center',
                        'wrap_text' => true,
                    ],
                    'align' => 'center',

                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_B17);
                $cell_heading_B18 = [
                    'cell' => 'A' . ($row_num + 3),
                    'cell_merge' => 'F' . ($row_num + 3),
                    'data_text_value' => [
                        [
                            'text' => '( giá chưa bao gồm giá vận chuyển từ Trung Quốc về Hà Nội và chưa bao gồm VAT)',
                            'size' => 10,
                        ],
                    ],

                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_B18);

                return $sheet;

            });
        })->export('xlsx');

    }

    protected function header($sheet)
    {
        $sheet->setWidth(array(
            'A' => 10,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 10,
            'H' => 17,
            'I' => 17,
            'J' => 17,
            'K' => 17,
            'L' => 17,
            'M' => 17,
            'N' => 17,
            'O' => 50,

        ));
        // $sheet->mergeCells('B2:B4');
        // $sheet->mergeCells('C2:C4');
        // $sheet->mergeCells('B2:C2');

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
                ['text' => 'MST '],
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
                    'text' => 'BẢNG BÁO GIÁ',
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
        $cell_heading_B11 = [
            'cell' => 'F9',
            'cell_merge' => 'H9',
            'data_text_value' => [
                [
                    'text' => 'Thứ năm, ngày 14, tháng 10, năm 2021',
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
