
$(document).on('change', ".product_id", function () {
    $('.product_property_id').find('option').remove().end().append('<option value=""></option>');
    var token = $('._token').val();
    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') } });
    $(this).find('#list-pictures-product').empty();
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
                renderPicture(response.pictures);
                // data = response.pictures;
                // for (var i = 0; i < data.length; i++) {
                //     $('#list-pictures-product').append('<img class="picture" data-asset="'+ data[i].asset +'" src="'+ data[i].link +'" />');
                // }
            }
            if (response.property) {
                renderProperty(response.property);
            }

        },
        error: function (response) {

        }
    });

    function renderPicture(data) {
        for (var i = 0; i < data.length; i++) {
            $('#list-pictures-product').append('<img class="picture" data-asset="'+ data[i].asset +'" src="'+ data[i].link +'" />');
        }
    }

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
    $('.total_item_amount').val(price);
    $('.deposit').val(price * 0.7);
});

