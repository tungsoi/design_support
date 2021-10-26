
$(document).on('change', ".product_id", function () {
    parent = $(this).parents(".parent-tr");
    var token = $('._token').val();
    console.log($('.route_get_product').val());
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
            if (response.pictures){
                data = response.pictures;
                for (var i = 0; i < data.length; i++) {
                    parent.find('.list-pictures-product').append('<img style="width: 30px;height: 30px;margin: 2px 2px;" class="picture" data-asset="'+ data[i].asset +'" src="'+ data[i].link +'" />');
                }
            }
            if (response.property) {
                data = response.property;
                $.each(data, function (i, item) {
                    parent.find('.product_property_id').append($('<option>', {
                        value: item.id,
                        data_price: item.price,
                        text : item.text
                    }));
                });
                //renderProperty(response.property);
            }

        },
        error: function (response) {

        }
    });


    function renderProperty(data) {
        $.each(data, function (i, item) {
            $('.product_property_id').append($('<option>', {
                value: item.id,
                data_price: item.price,
                text : item.text
            }));
        });
    }
});

$(document).on('change', ".product_property_id", function () {
    price = $(this).find(':selected').attr('data_price');
    parent = $(this).parents(".has-many-items-form");
    order_qty = parent.find('.order_qty').val();
    parent.find('.amount_one_item').val(order_qty * price).attr("data_price",(price * order_qty));
    $('.price').val(price).attr('data_price',price);
    getTotalDeposit();
});

$(document).on('change', ".order_qty", function () {
    parent = $(this).parents(".has-many-items-form");
    order_qty = $(this).val();
    price = parent.find('.price').attr('data_price');
    parent.find('.amount_one_item').val(price * order_qty).attr("data_price",(price * order_qty));
    getTotalDeposit();
});

function getTotalDeposit() {
    // amount_one_item = $('.amount_one_item').val();
    total = 0;
    $(".amount_one_item").each(function () {
        value = $(this).attr("data_price");
        total += parseInt(value);
        return total;
    });
    $('.total_item_amount').val(total);
    $('.deposit').val(total * 0.7);
}
// product = $('.product').val();
// console.log(JSON.parse(product) );
// $.each(product, function (i, item) {
//     $('#mySelect').append($('<option>', {
//         value: item.value,
//         text : item.text
//     }));
// });

$('.btn-add-order').click(function ($e) {
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