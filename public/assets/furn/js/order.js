
$(document).on('change', ".quality", function () {
    console.log('ok');
    _quanlity = $(this).val();
    _price = $(this).parents(".has-many-products-form").find(".price").val();
    amountProductPrice(_quanlity, _price, $(this));
});

$(document).on('keyup change', ".price", function () {
    _price = $(this).val();
    _quanlity = $(this).parents(".has-many-products-form").find(".quality").val();
    console.log(_price, _quanlity);
    amountProductPrice(_quanlity, _price, $(this));
});

$(document).on('keyup change', ".value_use_payment", function () {
    _value_payment = $(this).val();
    _price = $(this).parents(".has-many-products-form").find(".service_price").val();
    amountPayment(_value_payment, _price, $(this));
});

$(document).on('keyup change', ".service_price", function () {
    _price = $(this).val();
    _value_payment = $(this).parents(".has-many-products-form").find(".value_use_payment").val();
    amountPayment(_value_payment, _price, $(this));
});

function amountPayment(value, price, $this) {
    total = value.replace(/,/g, "") * price.replace(/,/g, "");
    parent = $this.parents(".has-many-products-form").find('.payment_amount').val(total);
}

function amountProductPrice(quanlity, price, $this) {
    total = quanlity * price.replace(/,/g, "");
    parent = $this.parents(".has-many-products-form").find('.amount').val(total);
    totalPrice();
}

function totalPrice() {
    var total = 0;
    $(".amount").each(function (index, e) {
        value = $(this).val();
        value = value.replace(/,/g, "");
        total += parseInt(value);
        return total;
    });
    $('.amount_products_price').val(total);
    $('.default_deposite').val(total * 0.7);
    totalAmount();
}

// $(document).on('keyup change', ".amount_ship_service", function () {
//     totalAmount();
// });
$(document).on('keyup change', ".amount_other_service", function () {
    totalAmount();
});
$(document).on('keyup change', ".discount_value", function () {
    totalAmount();
});

function totalAmount() {
    val_amount_products_price = $('.amount_products_price').val().replace(/,/g, "") ?? 0;

    val_default_deposite = $('.default_deposite').val().replace(/,/g, "") ?? 0;

    // val_amount_ship_service = $('.amount_ship_service').val().replace(/,/g, "") ?? 0;

    val_amount_other_service = $('.amount_other_service').val().replace(/,/g, "") ?? 0;

    val_discount_value = $('.discount_value').val().replace(/,/g, "") ?? 0;

    value = (parseInt(val_amount_other_service) + parseInt(val_amount_products_price) + parseInt(val_default_deposite)) - parseInt(val_discount_value);
    $('.total_amount').val(value);
}

