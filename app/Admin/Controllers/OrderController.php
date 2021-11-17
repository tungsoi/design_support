<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\Cancel;
use App\Admin\Actions\Order\ConfirmOrdered;
use App\Admin\Actions\Order\ConfirmSuccess;
use App\Admin\Actions\Order\Deposite;
use App\Admin\Actions\Order\ExportAmount;
use App\Admin\Actions\Order\ExportPaymentBill;
use App\Admin\Actions\Order\ExportShipBill;
use App\Admin\Actions\Order\UpdateStatus;
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
use App\Admin\Support\Common;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;

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
        $grid->column('amount_products_price', 'Tổng tiền sản phẩm (VND)')->display(function () {
            return $this->amount_products_price ?  number_format($this->amount_products_price) : null;
        });
        $grid->column('amount_ship_service', 'Tổng phí vận chuyển (VND)')->display(function () {
            return $this->amount_ship_service ?  number_format($this->amount_ship_service) : null;
        });
        $grid->column('amount_other_service', 'Tổng phí phát sinh (VND)')->display(function () {
            return $this->amount_other_service ?  number_format($this->amount_other_service) : null;
        });
        $grid->column('discount_value', 'Tổng tiền giảm (VND)')->display(function () {
            return $this->discount_value ?  number_format($this->discount_value) : null;
        });
        $grid->column('total_amount', 'Tổng giá cuối (VND)')->display(function () {
            return $this->total_amount ?  number_format($this->total_amount) : null;
        });
        $grid->column('deposited', 'Đã cọc (VND)')->display(function () {
            return $this->deposited ?  number_format($this->deposited) : null;
        });
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
            $route = '/admin/orders/updateStatus';
            if ($this->row->status == 1) {
                $actions->append(new Deposite($actions->getKey()));
            } elseif ($this->row->status == 2) {
                $actions->append(new UpdateStatus($this->row->id, 3, $route, 'Xác nhận đã đặt hàng', 'fa-check', 'btn-info'));
            } elseif ($this->row->status == 3) {
                $actions->append(new UpdateStatus($this->row->id, 4, $route, 'Xác nhận thành công', 'fa-info-circle', 'btn-danger'));
            } elseif ($this->row->status == 4) {
                $actions->append(new UpdateStatus($this->row->id, 5, $route, 'Xác nhận xoá đơn hàng', 'fa-times', 'btn-primary'));
            }

            $actions->append(new ExportAmount($actions->getKey()));
            $actions->append(new ExportShipBill($actions->getKey()));
            $actions->append(new ExportPaymentBill($actions->getKey()));
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
            $form->select('customer_id', 'Khách hàng')->options($service->getListCustomer());
            $form->display('user_action_name', 'Người tạo')->default(Admin::user()->name);
            $form->display('action_time', 'Thời gian tạo')->default(now());
            $form->hidden('status')->default(1);
        });

        $form->column(6, function ($form) use ($service) {
            $form->currency('amount_products_price', 'Tổng tiền sản phẩm')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('default_deposite', 'Tiền cọc')->help('70% tổng tiền sản phẩm')->digits(0)->symbol('VND')->default(0)->readonly()->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_ship_service', 'Tiền vận chuyển nội địa')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('amount_other_service', 'Phí phát sinh')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('discount_value', 'Chiết khấu')->digits(0)->symbol('VND')->default(0)->attribute(['style' => 'width: 100% !important;']);
            $form->currency('total_amount', 'Tổng tiền')->digits(0)->symbol('VND')->readonly()->attribute(['style' => 'width: 100% !important;']);
        });

        $form->column(12, function ($form) use ($service) {

            $form->divider();
            $form->hasMany('products', '- Danh sách sản phẩm', function (Form\NestedForm $form) {
                $form->select('status', 'Trạng thái')->options(OrderProductStatus::pluck('name', 'id'))->default(1)->disable();
                $form->text('name_product', 'Tên sản phẩm')->rules(['required']);
                $form->number('quality', 'Số lượng')->default(1);
                $form->currency('price', 'Giá tiền')->digits(0)->symbol('VND');
                $form->currency('amount', 'Thành tiền')->digits(0)->symbol('VND')->readonly();
                $form->text('link', 'Link sản phẩm');
                $form->text('classify', 'Phân loại')->rules(['required']);
                $form->text('specify_detail', 'Chỉ định chi tiết')->rules(['required']);
                $form->select('payment_type', 'Loại thanh toán')->options(OrderProductStatus::PAYMENT_TYPE)->default(0);
                $form->currency('value_use_payment', 'Giá trị')->digits(2)->symbol('KG / M3');
                $form->currency('service_price', 'Giá tiền vận chuyển')->digits(0)->symbol('VND');
                $form->currency('payment_amount', 'Thành tiền vận chuyển')->digits(0)->symbol('VND');
                $form->text('payment_code', 'Mã giao dịch');
                $form->text('transport_code', 'Mã vận đơn');
                $form->text('note', 'Ghi chú');
                $form->text('dvt', 'Đơn vị tính');
                $form->multipleFile('images', 'Ảnh')
                    ->removable();
                $form->textarea('description', 'Mô tả chất liệu');
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

        Excel::create('File báo giá', function ($excel) use ($self, $products) {
            $excel->sheet('Báo giá sản phẩm', function (LaravelExcelWorksheet $sheet) use ($self, $products) {
                $sheet = MYExcel::header($sheet, 'BẢNG BÁO GIÁ');
                $sheet->cell('A10', function ($cell) {
                    $cell->setValue('TÊN SP');
                });
                $name = [];
                if ($products) {
                    foreach ($products as $key => $item) {
                        $name[] = $item->name_product;
                    }
                }

                $cell_heading_name_product = [
                    'cell' => 'B10',
                    'cell_merge' => 'C10',
                    'data_text_value' => [
                        [
                            'text' => implode(",", $name),
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_name_product);
                $sheet->cell('A11', function ($cell) {
                    $cell->setValue('MÃ SỐ');
                    $cell->setValignment('center');
                });

                $row_num = 13;
                $arrRow = ['A', 'D'];

                $number = 1;
                $countProduct = $products->count();

                if ($products) {
                    $number = 0;
                    $number_key = 1;
                    foreach ($products as $key => $item) {
                        if (!is_null($item['images'])) {
                            if ($key % 2 == 0) {
                                $_key = 0;
                            } else {
                                $_key = 1;
                            }
                            $sheet = MYExcel::getLogo($sheet, [
                                'cell' => $arrRow[$_key] . $row_num,
                                // 'cell' => 'A' . $row_num,
                                'width' => 300,
                                'height' => 150,
                                'file_path' => 'uploads/' . $item['images'][0]
                            ]);

                            if ($countProduct == 1) {
                                $row_num += 8;
                            }

                            if ($number_key  % 2 == 0 && $key % 2 != 0) {
                                $row_num = $row_num;
                            }

                            if ($key % 2 != 0 && $key != 0) {

                                $row_num += 8;
                            }
                            $number++;
                        } else {
                            $number = 2;
                        }
                    }
                }
                if ($countProduct <= 2 || $countProduct % 2 == 0) {
                    $row_nums = ($row_num + 1);
                } else {
                    $row_nums = ($row_num + 9);
                }
                $sheet->cell('A' . ($row_nums), function ($cell) {
                    $cell->setValue('STT');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('B' . ($row_nums), function ($cell) {
                    $cell->setValue('Tên sản phẩm');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('C' . ($row_nums), function ($cell) {
                    $cell->setValue('Chất liệu chung');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('D' . ($row_nums), function ($cell) {
                    $cell->setValue('Phân loại');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('E' . ($row_nums), function ($cell) {
                    $cell->setValue('Chỉ định chi tiết');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('F' . ($row_nums), function ($cell) {
                    $cell->setValue('Giá sản phẩm');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('G' . ($row_nums), function ($cell) {
                    $cell->setValue('SL');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('H' . ($row_nums), function ($cell) {
                    $cell->setValue('Thành tiền(VND)');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->getStyle("A" . ($row_nums) . ":H" . ($row_nums + 1))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
                $totalPrice = 0;
                if ($products) {
                    foreach ($products as $key => $item) {

                        $sheet->cell('A' . ($row_nums + 1), function ($cell) use ($key) {
                            $cell->setValue($key + 1);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('B' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->name_product ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('C' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->description ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->getStyle('C' . ($row_nums + 1))->applyFromArray(array(
                            'alignment' => array(
                                'wrap' => true
                            )
                        ));
                        $sheet->cell('D' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->classify ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('E' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->specify_detail ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('F' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->price ? number_format($item->price) : null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('G' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->quality ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('H' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->amount ? number_format($item->amount) : null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->getStyle("A" . ($row_nums + 1) . ":H" . ($row_nums + 1))->applyFromArray(array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '222222'),
                                ),
                            ),
                        ));
                        $totalPrice += ($item->amount);
                        $row_nums++;
                    }
                }
                $cell_heading_B14 = [
                    'cell' => 'A' . ($row_nums + 1),
                    'cell_merge' => 'G' . ($row_nums + 1),
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
                    'cell' => 'H' . ($row_nums + 1),
                    'data_text_value' => [
                        [
                            'text' => number_format($totalPrice),
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                    'valign' => 'center',
                ];
                $sheet->getStyle("A" . ($row_nums + 1) . ":H" . ($row_nums + 1))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
                $sheet = MYExcel::getHeading($sheet, $cell_heading_B15);


                $cell_heading_B16 = [
                    'cell' => 'A' . ($row_nums + 4),
                    'cell_merge' => 'E' . ($row_nums + 4),
                    'data_text_value' => [
                        [
                            'text' => 'Báo giá có giá trị trong vòng 30 ngày kể từ ngày làm báo giá',
                            'size' => 12,
                        ],
                    ],

                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_B16);

                $cell_heading_B17 = [
                    'cell' => 'G' . ($row_nums + 4),
                    'cell_merge' => 'H' . ($row_nums + 4),
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
                    'cell' => 'A' . ($row_nums + 5),
                    'cell_merge' => 'F' . ($row_nums + 5),
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

    public function exportExcelShipBill($id)
    {
        $self = $this;
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $products = OrderProduct::where('order_id', $id)->get();

        Excel::create('File bàn giao hàng hoá', function ($excel) use ($self, $products) {
            $excel->sheet('Bàn giao hàng hoá', function (LaravelExcelWorksheet $sheet) use ($self, $products) {
                $sheet = MYExcel::header($sheet, 'BIÊN BẢN BÀN GIAO HÀNG HÓA');

                $name = [];
                if ($products) {
                    foreach ($products as $key => $item) {
                        $name[] = $item->name_product;
                    }
                }
                $row_num = 10;
                $arrRow = ['A', 'D'];

                $number = 1;
                $countProduct = $products->count();

                if ($products) {
                    $number = 0;
                    $number_key = 1;
                    foreach ($products as $key => $item) {
                        if (!is_null($item['images'])) {
                            if ($key % 2 == 0) {
                                $_key = 0;
                            } else {
                                $_key = 1;
                            }
                            $sheet = MYExcel::getLogo($sheet, [
                                'cell' => $arrRow[$_key] . $row_num,
                                // 'cell' => 'A' . $row_num,
                                'width' => 300,
                                'height' => 150,
                                'file_path' => 'uploads/' . $item['images'][0]
                            ]);

                            if ($countProduct == 1) {
                                $row_num += 8;
                            }

                            if ($number_key  % 2 == 0 && $key % 2 != 0) {
                                $row_num = $row_num;
                            }

                            if ($key % 2 != 0 && $key != 0) {

                                $row_num += 8;
                            }
                            $number++;
                        } else {
                            $number = 2;
                        }
                    }
                }
                if ($countProduct <= 2 || $countProduct % 2 == 0) {
                    $row_nums = ($row_num + 1);
                } else {
                    $row_nums = ($row_num + 9);
                }

                $sheet->cell('A' . ($row_nums), function ($cell) {
                    $cell->setValue('Bên giao hàng');
                    $cell->setAlignment('center');
                });
                $cell_heading_name_cty = [
                    'cell' => 'B' . ($row_nums),
                    'cell_merge' => 'I' . ($row_nums),
                    'data_text_value' => [
                        [
                            'text' => 'Công ty TNHH Phát triển Thương mại Dịch vụ Long Hải',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_name_cty);
                $cell_heading_address = [
                    'cell' => 'B' . ($row_nums + 1),
                    'data_text_value' => [
                        [
                            'text' => 'Địa chỉ',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address);

                $cell_heading_address_cty = [
                    'cell' => 'C' . ($row_nums + 1),
                    'data_text_value' => [
                        [
                            'text' => ':521 Minh Khai, Vĩnh Tuy, Hai Bà Trưng, Hà Nội.',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address_cty);

                $cell_heading_tax = [
                    'cell' => 'B' . ($row_nums + 2),
                    'data_text_value' => [
                        [
                            'text' => 'Mã số thuế',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_tax);

                $cell_heading__value_tax = [
                    'cell' => 'C' . ($row_nums + 2),
                    'data_text_value' => [
                        [
                            'text' => ': 0109534169 ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading__value_tax);

                $cell_heading_represent = [
                    'cell' => 'B' . ($row_nums + 3),
                    'data_text_value' => [
                        [
                            'text' => 'Đại diện',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_represent);

                $cell_heading_value_represent = [
                    'cell' => 'C' . ($row_nums + 3),
                    'data_text_value' => [
                        [
                            'text' => ':Ông Lê Ngọc Long.  ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_value_represent);

                $cell_heading_position = [
                    'cell' => 'F' . ($row_nums + 3),
                    'data_text_value' => [
                        [
                            'text' => 'Chức vụ: Giám Đốc.',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_position);

                $sheet->cell('A' . ($row_nums + 4), function ($cell) {
                    $cell->setValue('Bên nhận hàng');
                });
                $cell_heading_recipient = [
                    'cell' => 'B' . ($row_nums + 4),
                    'data_text_value' => [
                        [
                            'text' => ': ông Lê Hữu Sáng',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_recipient);

                $cell_heading_address_recipient = [
                    'cell' => 'B' . ($row_nums + 5),
                    'data_text_value' => [
                        [
                            'text' => 'Địa chỉ',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address_recipient);

                $cell_heading_address_recipient_value = [
                    'cell' => 'C' . ($row_nums + 5),
                    'data_text_value' => [
                        [
                            'text' => ': Số 06, đường Trường Chinh, thành phố Hà Tĩnh',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address_recipient_value);

                $cell_heading_phone_recipient = [
                    'cell' => 'B' . ($row_nums + 6),
                    'data_text_value' => [
                        [
                            'text' => 'SĐT',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_phone_recipient);

                $cell_heading_phone_recipient_value = [
                    'cell' => 'C' . ($row_nums + 6),
                    'data_text_value' => [
                        [
                            'text' => ': 0948.634.567',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_phone_recipient_value);

                $cell_heading_note_ship = [
                    'cell' => 'A' . ($row_nums + 7),
                    'cell_merge' => 'E' . ($row_nums + 7),
                    'data_text_value' => [
                        [
                            'text' => 'Hai bên cùng nhau thống nhất số lượng giao nhận hàng như sau:',
                            'bold' => true,
                        ],
                    ],
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_note_ship);
                $row_nums = $row_nums + 1;
                $sheet->cell('A' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('STT');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('B' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('Tên sản phẩm');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('C' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('Chất liệu');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('D' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('Kích thước');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('E' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('ĐVT');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('F' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('SL');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('G' . ($row_nums + 8), function ($cell) {
                    $cell->setValue('Ghi chú');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->getStyle("A" . ($row_nums + 8) . ":G" . ($row_nums + 8))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
                $row_nums = $row_nums + 8;
                if ($products) {
                    foreach ($products as $key => $item) {

                        $sheet->cell('A' . ($row_nums + 1), function ($cell) use ($key) {
                            $cell->setValue($key + 1);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('B' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->name_product ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('C' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->description ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->getStyle('C' . ($row_nums + 1))->applyFromArray(array(
                            'alignment' => array(
                                'wrap' => true
                            )
                        ));
                        $sheet->cell('D' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->classify ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('E' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue(($item->specify_detail ?? null));
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('F' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->payment_type ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('G' . ($row_nums + 1), function ($cell) use ($item) {
                            $cell->setValue($item->quality ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->getStyle("A" . ($row_nums + 1) . ":G" . ($row_nums + 1))->applyFromArray(array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '222222'),
                                ),
                            ),
                        ));
                        $row_nums++;
                    }
                }
                $row_nums = $row_nums + 1;
                $cell_heading_note_footer = [
                    'cell' => 'A' . ($row_nums + 1),
                    'cell_merge' => 'I' . ($row_nums + 1),
                    'data_text_value' => [
                        [
                            'text' => 'Bên nhận hàng xác nhận bên giao hàng đã chuyển đủ số lượng hàng và đúng chủng loại  như trên .',
                        ],
                    ],
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_note_footer);
                $cell_heading_note_footer_2 = [
                    'cell' => 'A' . ($row_nums + 2),
                    'cell_merge' => 'I' . ($row_nums + 2),
                    'data_text_value' => [
                        [
                            'text' => 'Hai bên đồng ý, thống nhất ký tên . Biên bản được lập thành 2 bản , mỗi bên giữ 1 bản có giá trị pháp lý như nhau ',
                        ],
                    ],
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_note_footer_2);

                $cell_heading_benA = [
                    'cell' => 'B' . ($row_nums + 4),
                    'cell_merge' => 'C' . ($row_nums + 4),
                    'data_text_value' => [
                        [
                            'text' => 'Đại diện bên nhận',
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_benA);
                $cell_heading_benA_note = [
                    'cell' => 'B' . ($row_nums + 5),
                    'cell_merge' => 'C' . ($row_nums + 5),
                    'data_text_value' => [
                        [
                            'text' => '( Ký và ghi rõ họ tên )',
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_benA_note);


                $cell_heading_benB = [
                    'cell' => 'E' . ($row_nums + 4),
                    'cell_merge' => 'F' . ($row_nums + 4),
                    'data_text_value' => [
                        [
                            'text' => 'Đại diện bên giao',
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_benB);
                $cell_heading_benB_note = [
                    'cell' => 'E' . ($row_nums + 5),
                    'cell_merge' => 'F' . ($row_nums + 5),
                    'data_text_value' => [
                        [
                            'text' => '( Ký và ghi rõ họ tên )',
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_benB_note);
                return $sheet;
            });
        })->export('xlsx');
    }

    public function exportExcelPaymentBill($id)
    {
        $self = $this;
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $products = OrderProduct::where('order_id', $id)->get();
        Excel::create('File thanh toán đơn hàng', function ($excel) use ($self, $products) {
            $excel->sheet('Báo giá sản phẩm', function (LaravelExcelWorksheet $sheet) use ($self, $products) {
                $sheet = MYExcel::header($sheet, 'PHIẾU THANH TOÁN ĐƠN HÀNG');
                $row_num = 10;
                $sheet->cell('A' . ($row_num + 1), function ($cell) {
                    $cell->setValue('TÊN SP :');
                });
                $name = [];
                if ($products) {
                    foreach ($products as $key => $item) {
                        $name[] = $item->name_product;
                    }
                }

                $cell_heading_name_product = [
                    'cell' => 'B' . ($row_num + 1),
                    'cell_merge' => 'C' . ($row_num + 1),
                    'data_text_value' => [
                        [
                            'text' => implode(",", $name),
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_name_product);
                $sheet->cell('A' . ($row_num + 2), function ($cell) {
                    $cell->setValue('MÃ SỐ :');
                    $cell->setValignment('center');
                });
                $arrRow = ['A', 'D'];
                $row_num = 14;
                $number = 1;
                $countProduct = $products->count();
                if ($products) {
                    $number = 0;
                    $number_key = 1;
                    foreach ($products as $key => $item) {
                        if (!is_null($item['images'])) {
                            if ($key % 2 == 0) {
                                $_key = 0;
                            } else {
                                $_key = 1;
                            }
                            $sheet = MYExcel::getLogo($sheet, [
                                'cell' => $arrRow[$_key] . $row_num,
                                // 'cell' => 'A' . $row_num,
                                'width' => 300,
                                'height' => 150,
                                'file_path' => 'uploads/' . $item['images'][0]
                            ]);

                            if ($countProduct == 1) {
                                $row_num += 8;
                            }

                            if ($number_key  % 2 == 0 && $key % 2 != 0) {
                                $row_num = $row_num;
                            }

                            if ($key % 2 != 0 && $key != 0) {

                                $row_num += 8;
                            }
                            $number++;
                        } else {
                            $number = 2;
                        }
                    }
                }
                if ($countProduct <= 2 || $countProduct % 2 == 0) {
                    $row_nums = ($row_num + 1);
                } else {
                    $row_nums = ($row_num + 9);
                }

                $sheet->cell('A' . ($row_nums), function ($cell) {
                    $cell->setValue('BÊN BÁN');
                });
                $cell_heading_name_cty = [
                    'cell' => 'B' . ($row_nums),
                    'cell_merge' => 'I' . ($row_nums),
                    'data_text_value' => [
                        [
                            'text' => 'Công ty TNHH Phát triển Thương mại Dịch vụ Long Hải',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_name_cty);
                $cell_heading_address = [
                    'cell' => 'B' . ($row_nums + 1),
                    'data_text_value' => [
                        [
                            'text' => 'Địa chỉ',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address);

                $cell_heading_address_cty = [
                    'cell' => 'C' . ($row_nums + 1),
                    'data_text_value' => [
                        [
                            'text' => ':521 Minh Khai, Vĩnh Tuy, Hai Bà Trưng, Hà Nội.',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address_cty);

                $cell_heading_tax = [
                    'cell' => 'B' . ($row_nums + 2),
                    'data_text_value' => [
                        [
                            'text' => 'Mã số thuế',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_tax);

                $cell_heading__value_tax = [
                    'cell' => 'C' . ($row_nums + 2),
                    'data_text_value' => [
                        [
                            'text' => ': 0109534169 ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading__value_tax);

                $cell_heading_represent = [
                    'cell' => 'B' . ($row_nums + 3),
                    'data_text_value' => [
                        [
                            'text' => 'Đại diện',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_represent);

                $cell_heading_value_represent = [
                    'cell' => 'C' . ($row_nums + 3),
                    'data_text_value' => [
                        [
                            'text' => ':Ông Lê Ngọc Long.  ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_value_represent);

                $cell_heading_position = [
                    'cell' => 'F' . ($row_nums + 3),
                    'data_text_value' => [
                        [
                            'text' => 'Chức vụ: Giám Đốc.',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_position);

                $sheet->cell('A' . ($row_nums + 4), function ($cell) {
                    $cell->setValue('BÊN MUA ');
                });
                $cell_heading_recipient = [
                    'cell' => 'B' . ($row_nums + 4),
                    'data_text_value' => [
                        [
                            'text' => ': ông Lê Hữu Sáng',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_recipient);

                $cell_heading_address_recipient = [
                    'cell' => 'B' . ($row_nums + 5),
                    'data_text_value' => [
                        [
                            'text' => 'Địa chỉ',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address_recipient);

                $cell_heading_address_recipient_value = [
                    'cell' => 'C' . ($row_nums + 5),
                    'data_text_value' => [
                        [
                            'text' => ': Số 06, đường Trường Chinh, thành phố Hà Tĩnh',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_address_recipient_value);

                $cell_heading_phone_recipient = [
                    'cell' => 'B' . ($row_nums + 6),
                    'data_text_value' => [
                        [
                            'text' => 'SĐT',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_phone_recipient);

                $cell_heading_phone_recipient_value = [
                    'cell' => 'C' . ($row_nums + 6),
                    'data_text_value' => [
                        [
                            'text' => ': 0948.634.567',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_phone_recipient_value);

                // begin create table info product
                $cell_heading_note_ship = [
                    'cell' => 'A' . ($row_nums + 7),
                    'cell_merge' => 'E' . ($row_nums + 7),
                    'data_text_value' => [
                        [
                            'text' => 'Thông tin sản phẩm và giá trị đơn hàng',
                            'bold' => true,
                        ],
                    ],
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_heading_note_ship);
                $column_Table_Product = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                $row_Table_Product = $row_nums + 8;
                $textColmn_Table_Product = ['STT', 'Tên sản phẩm', 'Chất liệu ', 'Kích thước', 'ĐVT', 'SL', 'Giá sản phẩm', 'Thành tiền(1)'];
                $alignmentTable_Product = [];
                $valignment_Product = [];
                $totalDon = 0;
                $sheet = MYExcel::getHeaderTable($sheet, $column_Table_Product, $row_Table_Product, $textColmn_Table_Product, $alignmentTable_Product, $valignment_Product);
                if ($products) {
                    foreach ($products as $key => $item) {
                        $sheet->cell('A' . ($row_Table_Product + 1), function ($cell) use ($key) {
                            $cell->setValue($key + 1);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('B' . ($row_Table_Product + 1), function ($cell) use ($item) {
                            $cell->setValue($item->name_product ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('C' . ($row_Table_Product + 1), function ($cell) use ($item) {
                            $cell->setValue($item->description ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->getStyle('C' . ($row_Table_Product + 1))->applyFromArray(array(
                            'alignment' => array(
                                'wrap' => true
                            )
                        ));
                        $sheet->cell('D' . ($row_Table_Product + 1), function ($cell) use ($item) {
                            $cell->setValue($item->classify ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('E' . ($row_Table_Product + 1), function ($cell) use ($item) {
                            $cell->setValue($item->dvt ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('F' . ($row_Table_Product + 1), function ($cell) use ($item) {
                            $cell->setValue($item->quality ?? null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('G' . ($row_Table_Product + 1), function ($cell) use ($item) {
                            $cell->setValue($item->price ? number_format($item->price) : null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->cell('H' . ($row_Table_Product + 1), function ($cell) use ($item, $totalDon) {

                            $cell->setValue($item->amount ? number_format($item->amount) : null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                        $sheet->getStyle("A" . ($row_Table_Product + 1) . ":H" . ($row_Table_Product + 1))->applyFromArray(array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '222222'),
                                ),
                            ),
                        ));
                        $row_Table_Product++;
                        $totalDon += $item->amount;
                    }
                }
                // end create table info product
                $row_payment_ship = $row_Table_Product + 1;
                // begin create table payment ship china into HN
                $cell_heading_note_ship = [
                    'cell' => 'A' . ($row_payment_ship + 1),
                    'cell_merge' => 'E' . ($row_payment_ship + 1),
                    'data_text_value' => [
                        [
                            'text' => 'Tiền vận chuyển hàng từ Trung Quốc về Hà Nội',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_heading_note_ship);
                $column_Table_Payment = ['A', 'B', 'C', 'D', 'E', 'F'];
                $row_Table_Payment = $row_payment_ship + 2;
                $textColmn_Table_Payment = ['STT', 'Loại hàng', 'ĐVT', 'Số lượng', 'Giá tiền', 'Thành tiền(2)'];
                $alignmentTable_Payment = [];
                $valignment_Payment = [];
                $totalTQHN = 0;
                $sheet = MYExcel::getHeaderTable($sheet, $column_Table_Payment, $row_Table_Payment, $textColmn_Table_Payment, $alignmentTable_Payment, $valignment_Payment);
                if ($products) {
                    foreach ($products as $key => $item) {
                        $sheet->cell('A' . ($row_payment_ship + 3), function ($cell) use ($key) {
                            $cell->setValue($key + 1);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            // STT
                        });
                        $sheet->cell('B' . ($row_payment_ship + 3), function ($cell) use ($item) {
                            $name = ($item->quality ?? null) . ($item->name_product ?? null);
                            $cell->setValue($name);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            // Loại hàng
                        });
                        $sheet->cell('C' . ($row_payment_ship + 3), function ($cell) use ($item) {
                            $cell->setValue(($item->payment_type == 0 ? 'KG' : 'Khối'));
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            // ĐVT
                        });
                        $sheet->cell('D' . ($row_payment_ship + 3), function ($cell) use ($item) {
                            $cell->setValue(($item->value_use_payment ?? null));
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            // Số lượng
                        });
                        $sheet->cell('E' . ($row_payment_ship + 3), function ($cell) use ($item) {
                            $cell->setValue($item->service_price ? number_format($item->service_price) : null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            // Giá tiền
                        });
                        $sheet->cell('F' . ($row_payment_ship + 3), function ($cell) use ($item, $totalTQHN) {

                            $cell->setValue($item->payment_amount ? number_format($item->payment_amount) : null);
                            $cell->setFont(MYExcel::getFont());
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            // Thành tiền(2)
                        });
                        $sheet->getStyle("A" . ($row_payment_ship + 3) . ":F" . ($row_payment_ship + 3))->applyFromArray(array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '222222'),
                                ),
                            ),
                        ));
                        $totalTQHN += $item->payment_amount;
                        $row_payment_ship++;
                    }
                }
                // end create table payment ship china into HN
                $row_to = $row_payment_ship + 2;
                $cell_total_price = [
                    'cell' => 'A' . ($row_to + 2),
                    'cell_merge' => 'E' . ($row_to + 2),
                    'data_text_value' => [
                        [
                            'text' => 'TỔNG = (1) + (2)',
                            'bold' => true,
                        ],
                    ],
                ];
                $sheet->getStyle("A" . ($row_to + 2) . ":E" . ($row_to + 2))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
                $sheet = MYExcel::getHeading($sheet, $cell_total_price);
                $cell_val_total_price = [
                    'cell' => 'F' . ($row_to + 2),
                    'data_text_value' => [
                        [
                            'text' => number_format($totalDon + $totalTQHN),
                        ],
                    ],
                ];
                $sheet->getStyle("A" . ($row_to + 2) . ":F" . ($row_to + 2))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '222222'),
                        ),
                    ),
                ));
                $sheet = MYExcel::getHeading($sheet, $cell_val_total_price);
                $row_footer_sheet = $row_to + 3;
                $cell_footer_a1 = [
                    'cell' => 'A' . ($row_footer_sheet + 1),
                    'cell_merge' => 'H' . ($row_footer_sheet + 1),
                    'data_text_value' => [
                        [
                            'text' => 'Số tiền bằng chữ : ' . Common::docso($totalDon + $totalTQHN),
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_footer_a1);
                $cell_footer_a2 = [
                    'cell' => 'A' . ($row_footer_sheet + 2),
                    'cell_merge' => 'E' . ($row_footer_sheet + 2),
                    'data_text_value' => [
                        [
                            'text' => 'Địa điểm giao hàng : Hà Tĩnh ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_footer_a2);
                $cell_footer_a3 = [
                    'cell' => 'A' . ($row_footer_sheet + 3),
                    'cell_merge' => 'E' . ($row_footer_sheet + 3),
                    'data_text_value' => [
                        [
                            'text' => 'Phương thức thanh toán: ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_footer_a3);
                $cell_footer_a4 = [
                    'cell' => 'A' . ($row_footer_sheet + 4),
                    'cell_merge' => 'H' . ($row_footer_sheet + 4),
                    'data_text_value' => [
                        [
                            'text' => '    -Thanh toán bằng tiền mặt hoặc chuyển khoản qua số tài khoản 884550552222 Pvcombank -  chủ tài khoản Lê Ngọc Long',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_footer_a4);
                $cell_footer_a5 = [
                    'cell' => 'A' . ($row_footer_sheet + 5),
                    'cell_merge' => 'H' . ($row_footer_sheet + 5),
                    'data_text_value' => [
                        [
                            'text' => '    -Thanh toán trước 0% giá trị hợp đồng : 0đ',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_footer_a5);

                $cell_footer_a6 = [
                    'cell' => 'A' . ($row_footer_sheet + 6),
                    'cell_merge' => 'H' . ($row_footer_sheet + 6),
                    'data_text_value' => [
                        [
                            'text' => '  - Số tiền còn lại thanh toán sau khi giao hàng : 35.200.000đ ( Ba mươi lăm triệu hai trăm nghìn đồng )',
                        ],
                    ],
                ];
                $sheet = MYExcel::getHeading($sheet, $cell_footer_a6);
                $cell_ky_benA = [
                    'cell' => 'B' . ($row_footer_sheet + 9),
                    'cell_merge' => 'C' . ($row_footer_sheet + 9),
                    'data_text_value' => [
                        [
                            'text' => 'Đại diện bên mua',
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_ky_benA);
                $cell_ky_benA_note = [
                    'cell' => 'B' . ($row_footer_sheet + 10),
                    'cell_merge' => 'C' . ($row_footer_sheet + 10),
                    'data_text_value' => [
                        [
                            'text' => '( Ký và ghi rõ họ tên )',
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_ky_benA_note);


                $cell_ky_benB = [
                    'cell' => 'E' . ($row_footer_sheet + 9),
                    'cell_merge' => 'F' . ($row_footer_sheet + 9),
                    'data_text_value' => [
                        [
                            'text' => 'Đại diện bên bán',
                            'bold' => true,
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_ky_benB);
                $cell_ky_benB_note = [
                    'cell' => 'E' . ($row_footer_sheet + 10),
                    'cell_merge' => 'F' . ($row_footer_sheet + 10),
                    'data_text_value' => [
                        [
                            'text' => '( Ký và ghi rõ họ tên )',
                        ],
                    ],
                    'align' => 'center',
                ];

                $sheet = MYExcel::getHeading($sheet, $cell_ky_benB_note);
                return $sheet;
            });
        })->export('xlsx');
    }

    public function deposite($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->formDeposite($id));
    }

    public function formDeposite($id)
    {
        $order = Order::find($id);
        $form = new Form(new Order());

        $form->setAction(route('admin.orders.submitDeposite'));
        $form->display('amount_products_price', 'Tổng tiền')->default(number_format($order->amount_products_price));
        $form->display('deposite_default', 'Tổng tiền cọc')->default(number_format($order->amount_products_price * 0.7))
            ->help('70% tong gia tri san pham'); // tien coc mac dinh theo tat ca cac don

        $form->currency('deposit', 'Tiền cọc')->symbol('VND')->digits(0)->required(); // tien khach hang chuyen khoan de vao coc
        $form->hidden('user_id_deposited')->default(Admin::user()->id);
        $form->hidden('deposited_at')->default(now());
        $form->hidden('id_order')->default($id);
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->disableReset();
        return $form;
    }
    public function submitDeposite(Request $request)
    {
        $order = Order::find($request->id_order);
        if ($order) {
            $order->status = 2;
            // $order->deposited_at = $request->deposited_at;
            $order->deposited = $request->deposit;
            // $order->user_id_deposited = $request->user_id_deposited;
            $order->save();
        };
        return redirect(route('admin.orders.index'));
    }

    public function updateStatus(Request $request)
    {
        $order = Order::find($request->id);
        $data = [
            'status'    =>  $request->status
        ];
        if ($request->status == 3) {
            $data['user_id_ordered']    =  Admin::user()->id;
            $data['ordered_at'] =   now();
        } else if ($request->status == 4) {
            $data['user_id_success']    =  Admin::user()->id;
            $data['success_at'] =   now();
        } else if ($request->status == 5) {
            $data['user_id_cancel']    =  Admin::user()->id;
            $data['cancel_at'] =   now();
        }

        $order->update($data);

        admin_toastr('Lưu thành công', 'success');

        return response()->json([
            'status'    =>  true,
            'message'   =>  'success'
        ]);
    }
}
