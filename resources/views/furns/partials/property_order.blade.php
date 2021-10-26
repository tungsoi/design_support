<input type="hidden" class="route_get_product" value="{{$route_get_product}}">
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th style="width: 200px!important;">Sản phẩm</th>
        <th >Optison sản phẩm</th>
        <th >Ảnh</th>
        <th >Số lượng</th>
        <th >Giá tiền sản phẩm</th>
        <th >Tổng tiền sản phẩm</th>
    </tr>
    </thead>
    <tbody class="table-property">
        <tr class="option-default parent-tr" hidden>
            <td>1</td>
            <td>
                <select  class="mySelect2 select-custom user_id form-control product_id select2-hidden-accessible" style="width: 100%;" name="product_id" data-value="" tabindex="-1" aria-hidden="true">
                    @foreach($products as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </td>
            <td class="td-product-property">
                <select id="mySelect2" class="mySelect2 select-custom user_id form-control product_property_id select2-hidden-accessible" style="width: 100%;" name="product_id" data-value="" tabindex="-1" aria-hidden="true">

                </select>
            </td>
            <td class="list-pictures-product"></td>
            <td>
                <div class="form-group  ">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-primary">-</button></span><input style="width: 100%; text-align: center;" type="text" id="order_qty" name="order_qty" value="1" class="form-control order_qty initialized" placeholder="Nhập Số lượng đặt mua (1)"><span class="input-group-btn"><button type="button" class="btn btn-success">+</button></span></div>
                        </div>
                    </div>
                </div>
            </td>
            <td>2</td>
            <td>2</td>
        </tr>
    <tr>

    </tr>
    </tbody>
</table>




