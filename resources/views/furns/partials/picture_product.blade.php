<div class="list-pictures-product">

</div>

<input type="hidden" class="route_get_product" value="{{ $route_get_product  }}" />

<script>
    $('body').on('click','.picture',function () {
        asset = $(this).attr('data-asset');
        $(this).parents(".list-pictures-product").find('img').css('border','none');
        // $('.list-pictures-product img').css('border','none');
        $(this).css('border','2px solid red');
        $('.picture').val(asset);
    });
</script>
<style>
    .list-pictures-product img{
        cursor: pointer;
        width: 50px !important;
        height: 50px;
        border-radius: 3px;
        margin: 0px 10px 10px 0px;
    }
</style>