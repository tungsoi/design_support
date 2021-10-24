
$(document).on('change', ".product_id", function () {
    parent = $(this).parents(".has-many-items-form");
    $('.product_property_id').find('option').remove().end().append('<option value=""></option>');
    var token = $('._token').val();
    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') } });
    parent.find('.list-pictures-product').empty();
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
            if (response.pictures){
                // renderPicture(response.pictures);
                data = response.pictures;
                for (var i = 0; i < data.length; i++) {
                    parent.find('.list-pictures-product').append('<img class="picture" data-asset="'+ data[i].asset +'" src="'+ data[i].link +'" />');
                }
            }
            if (response.property) {
                // parent.find('.price').val()
                renderProperty(response.property);
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
