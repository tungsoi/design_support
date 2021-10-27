<input type="hidden" class="route_get_product" value="{{$route_get_product}}">
<a style="margin-bottom: 20px;float: right;" class="btn btn-add-order btn-sm btn-primary">Thêm sản phẩm</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th style="width: 200px!important;">Sản phẩm</th>
        <th >Optison sản phẩm</th>
        <th >Ảnh</th>
        <th style="width: 150px!important;">Số lượng</th>
        <th >Giá tiền sản phẩm</th>
        <th >Tổng tiền sản phẩm</th>
        <th >Hành động</th>
    </tr>
    </thead>
    <tbody class="table-property">
        @foreach($orderItem as $key => $item)
            <tr>
                <td>{{$key+1}}</td>
                <td>
                    <select  class="mySelect2 select-custom user_id form-control product_id select2-hidden-accessible" style="width: 100%;" name="product_id[]" data-value="" tabindex="-1" aria-hidden="true">
                        <option ></option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if($item->id=== $product->id) selected='selected' @endif> {{ $product->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select  id="mySelect2" class="mySelect2 select-custom user_id form-control product_property_id select2-hidden-accessible"  style="width: 100%;" name="product_id[]" data-value="" tabindex="-1" aria-hidden="true">
                        <option ></option>
                        @foreach($productProperty as $property)
                            <option value="{{ $property->id }}" @if($item->product_property_id=== $property->id) selected='selected' @endif> {{ 'Size: ' . $property->size  .' -- ' .  number_format($property->price) }}</option>
                        @endforeach
                    </select>
                    {{--{{$item->product_property_id}}--}}
                </td>
                <td></td>
                <td>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="input-group form-order_qty">
                                <input  min="1" type="number"  name="order_qty[]" value="{{ $item->order_qty }}" class="form-control order_qty " placeholder="Nhập Số lượng đặt mua">
                            </div>
                        </div>
                    </div>

                </td>
                <td style="text-align: center;">{{ number_format($item->price)}}</td>
                <input type="hidden" class="price" name="price[]" value="{{$item->price}}">
                <input type="hidden" class="amount_one_item_val" name="amount_one_item_val[]" value="{{ ($item->price * $item->order_qty) }}" >
                <td style="text-align: center;">{{number_format($item->order_qty * $item->price)}}</td>
                <td style="text-align: center;">
                    <a href="javascript:void(0);" data-id="1" class="grid-row-delete btn btn-xs btn-danger remove-order" data-toggle="tooltip" title="" data-original-title="Xóa">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        <tr class="option-default parent-tr" hidden>
            <td>1</td>
            <td>
                <select  class="mySelect2 select-custom user_id form-control product_id select2-hidden-accessible" style="width: 100%;" name="product_id[]" data-value="" tabindex="-1" aria-hidden="true">
                    <option ></option>
                    @foreach($products as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </td>
            <td class="td-product-property">
                <select id="mySelect2" class="mySelect2 select-custom user_id form-control product_property_id select2-hidden-accessible" style="width: 100%;" name="product_property_id[]" data-value="" tabindex="-1" aria-hidden="true">
                </select>
            </td>
            <td class="list-pictures-product"></td>
            <td>
                <div class="col-sm-12">
                    <div class="input-group">
                        <div class="input-group form-order_qty">
                            {{--<span class="input-group-btn">--}}
                                {{--<button type="button" class="btn btn-primary btn-dow">-</button>--}}
                            {{--</span>--}}
                            <input  min="1" type="number"  name="order_qty[]" value="1" class="form-control order_qty " placeholder="Nhập Số lượng đặt mua">
                            {{--<span class="input-group-btn">--}}
                                {{--<button type="button" class="btn btn-success btn-up">+</button>--}}
                            {{--</span>--}}
                        </div>
                    </div>
                </div>
            </td>
            <td class="price" style="text-align: center;"></td>
            <input type="hidden" class="price" name="price[]">
            <input type="hidden" class="amount_one_item_val" name="amount_one_item_val[]" value="0" >
            <td class="amount_one_item" style="text-align: center;"></td>
            <td style="text-align: center;">
                <a href="javascript:void(0);" data-id="1" class="grid-row-delete btn btn-xs btn-danger remove-order" data-toggle="tooltip" title="" data-original-title="Xóa">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
    <tr>

    </tr>
    </tbody>
</table>




