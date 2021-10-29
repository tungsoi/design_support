
$(document).on('change', ".product_id", function () {
    // console.log($(this).val());
    parent = $(this).parents(".has-many-list_items-form");
    var token = $('._token').val();
    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        url: $('.route_get_product').val(),
        type: "GET",
        data: {
            data: $(this).val(),
        },
        header:{
            'X-CSRF-TOKEN': token
        },
        success: function (response) {
            console.log(response);
            // if (response.pictures){
            //     parent.find('.list-pictures-product').empty();
            //     data = response.pictures;
            //     for (var i = 0; i < data.length; i++) {
            //         parent.find('.list-pictures-product').append('<img style="width: 30px;height: 30px;margin: 2px 2px;" class="picture" data-asset="'+ data[i].asset +'" src="'+ data[i].link +'" />');
            //     }
            // }
            if (response.property) {
                data = response.property;
                console.log(data);
                parent.find('.product_property_id').empty();
                parent.find('.price').empty();
                parent.find('.amount_one_item').empty();
                parent.find('.product_property_id').append('<option></option>')
                $.each(data, function (i, item) {
                    parent.find('.product_property_id').append($('<option>', {
                        value: item.id,
                        data_price: item.price,
                        text : item.text,
                    }));
                });
            }

        },
        error: function (response) {

        }
    });
});

$(document).on('change', ".product_property_id", function () {
    price = $(this).find(':selected').attr('data_price');
    parent = $(this).parents(".has-many-list_items-form");
    order_qty = parent.find('.order_qty').val();
    parent.find('.price').html(parseInt(price).toLocaleString()).val(parseInt(price)).attr('data_price',price);
    parent.find('.amount_one_item').html(price * order_qty).val(price * order_qty).attr('data_price',price * order_qty);
    getTotalDeposit();
});

$(document).on('change', ".order_qty", function () {
    renderPrice($(this));
});

function renderPrice($this) {
    parent = $this.parents(".has-many-list_items-form");
    order_qty = $this.val();
    price = parent.find('.price').attr('data_price');
    parent.find('.amount_one_item').html(price * order_qty).val(price * order_qty).attr('data_price',price * order_qty);
    getTotalDeposit();
}

function getTotalDeposit() {
    as = $('.amount_one_item').length;
    console.log(as,'ok');
    var total = 0;

    $(".amount_one_item").each(function (index,e) {
        value = $(this).attr("data_price");
        console.log(value,'value');
        total += parseInt(value) ;
        return total;
    });

    $('.total_item_amount').val(total);
    $('.deposit').val(total * 0.7);
}

$(document).on('click', '#btn-add-order', function ($e) {
    console.log('ok');
    content = $('.option-default ').clone().removeClass('option-default');
    content.find('select.select2').removeClass('select2-hidden-accessible');
    if (content.find('.select-custom').data('select2')) {
        content.find('.select-custom').select2('destroy');
    }
    content.find('.select2').remove();
    content.show();
    content.appendTo('.table ');
    content.find('.select2').select2();
    var data = {
    };
    content.find(".mySelect2").select2({
        data: data
    });

});

$(document).on('click','.btn-up',function () {
    value = $(this).parents(".form-order_qty").find('input').val();
    $(this).parents(".form-order_qty").find('input').val(parseInt(value)+1);
    renderPrice($(this));
});

$(document).on('click','.btn-dow',function () {
    value = $(this).parents(".form-order_qty").find('input').val();
    $(this).parents(".form-order_qty").find('input').val(parseInt(value)-1);
    renderPrice($(this));
});

$(document).on('click','.remove-order',function () {
     $(this).parents(".parent-tr").remove();

});

$(document).on('click','.ok',function ($e) {
     console.log('asasasa',$e);

});

$('body').on('click','#change-status',function () {
   console.log('ok');
});