// số lượng sản phẩm
$(document).on('change', ".quality", function () {
    _quanlity = $(this).val();
    _price = $(this).parents(".has-many-products-form").find(".price").val();
    amountProductPrice(_quanlity, _price, $(this));
});
// giá sản phẩm
$(document).on('keyup change', ".price", function () {
    _price = $(this).val();
    _quanlity = $(this).parents(".has-many-products-form").find(".quality").val();
    amountProductPrice(_quanlity, _price, $(this));
});
// giá trị m3/kg
$(document).on('keyup change', ".value_use_payment", function () {
    _value_payment = $(this).val();
    _price = $(this).parents(".has-many-products-form").find(".service_price").val();
    amountPayment(_value_payment, _price, $(this));
});
//Giá tiền vận chuyển
$(document).on('keyup change', ".service_price", function () {
    _price = $(this).val();
    _value_payment = $(this).parents(".has-many-products-form").find(".value_use_payment").val();
    amountPayment(_value_payment, _price, $(this));
});

//note chi phi
$(document).on('keyup change', ".noteService", function () {
    totalAmountOtherService()
});
//remove note orther service
$('.has-many-noteService-forms').on('click', '.remove', function () {
    console.log('remove');
    $(this).parents(".has-many-noteService-form").remove();
    totalAmountOtherService()
});


// tinh tong chi phi phat sinh
function totalAmountOtherService() {
    var total = 0;
    $(".money").each(function (index, e) {
        if ($(this).parents(".has-many-noteService-form").css('display') === 'block') {
            value = $(this).val();
            value = value.replace(/,/g, "");
            total += parseInt(value);
            return total;
        }
        return total;
    });
    $('.amount_other_service').val(total);
    totalAmount();
}

// tính tiền vận chuyển
function amountPayment(value, price, $this) {
    total = value.replace(/,/g, "") * price.replace(/,/g, "");
    parent = $this.parents(".has-many-products-form").find('.payment_amount').val(total);
    totalPriceTransport();
}
// tính tiền trên từng sản phẩm
function amountProductPrice(quanlity, price, $this) {
    total = quanlity * price.replace(/,/g, "");
    parent = $this.parents(".has-many-products-form").find('.amount').val(total);
    totalPrice();
}

//remove product
$('.has-many-products-forms').on('click', '.remove', function () {
    $(this).parents(".has-many-products-form").remove();
    totalPriceTransport();
    totalPrice();
});

function totalPriceTransport() {
    var total = 0;
    $(".payment_amount").each(function (index, e) {
        value = $(this).val();
        value = value.replace(/,/g, "");
        total += parseInt(value);
        return total;
    });
    $('.amount_ship_service').val(total);
    totalAmount();
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

//Phí phát sinh
$(document).on('keyup change', ".amount_other_service", function () {
    totalAmount();
});

//Chiết khấu
$(document).on('keyup change', ".discount_value", function () {
    totalAmount();
});


function totalAmount() {
    val_amount_products_price = $('.amount_products_price').val().replace(/,/g, "") ?? 0;
    console.log(val_amount_products_price, 'val_amount_products_price');
    // val_default_deposite = $('.default_deposite').val().replace(/,/g, "") ?? 0;

    val_amount_ship_service = $('.amount_ship_service').val().replace(/,/g, "") ?? 0;
    val_amount_other_service = $('.amount_other_service').val().replace(/,/g, "") ?? 0;
    val_discount_value = $('.discount_value').val().replace(/,/g, "") ?? 0;
    value = (parseInt(val_amount_other_service) + parseInt(val_amount_products_price) + parseInt(val_amount_ship_service)) - parseInt(val_discount_value);
    console.log(val_amount_other_service, 'val_amount_other_service');
    console.log(val_amount_products_price, 'val_amount_products_price');
    console.log(val_amount_ship_service, 'val_amount_ship_service');
    console.log(val_discount_value, 'val_discount_value');
    $('.total_amount').val(value);
}

