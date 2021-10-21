<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="fullpage" class="">
        <div class="section pd-0" id="products">
            <div class="container-fluid pd-0 bg-white h-100" style="margin-top: 80px;">
                <div class="row">
                    <div class="col-lg-12" style="padding: 20px 20px;">
                        <h6 style="color: #646464 !important; text-align: left">
                            <a href="{{ route('furn.home') }}" style="color: #646464 !important; text-align: left">Trang chủ</a> /
                            <a href="{{ route('furn.product.product-by-category', $product->category->code) }}" style="color: #646464 !important; text-align: left">{{ $product->category->name }}</a> /
                            {{ $product->code}}
                        </h6>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-6" style="">
                                @if ($product->pictures != null && is_array($product->pictures))
                                        <ul id="imageGallery">
                                            @foreach ($product->pictures as $key => $picture)
                                                <li data-thumb="{{ asset('uploads/'.$picture) }}" data-src="{{ asset('uploads/'.$picture) }}">
                                                    <img src="{{ asset('uploads/'.$picture) }}" />
                                                </li>
                                            @endforeach

                                        </ul>
                                @endif
                            </div>
                            <div class="col-lg-5" style="color: #646464;
                            text-align: left; height: 100%; overflow: hidden !important; padding: 20px !important;">
                                <div class="row">
                                    <div class="col-lg-6">

                                        {{ $product->category->name }}

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        {{ $product->code }}
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3 class="text-uppercase">{{ $product->name }}</h3>
                                    </div>
                                    <div class="col-lg-12 size-product">
                                        <span>Kích thước</span>
                                        <select class="none-boder-sl" id="select-size">
                                            @foreach($properties_product as $properties)
                                                <option data-price={{ $properties['price']  }}>{{$properties['size']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-12">
                                        <br><span>Giá tiền </span>
                                        <div id="show-price">

                                        </div>
                                        {{--<h4 class="text-uppercase" style="font-weight: 400; color: rgb(172, 83, 83);">--}}
                                            {{--Liên hệ--}}
                                        {{--</h4>--}}
                                        <br>
                                    </div>
                                    <div class="col-lg-12">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>

        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
        <br><br><br>
    </div>


    @include('furns.script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.3.2/css/lightgallery.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.3.2/js/lightgallery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css">
    <script>
        $(document).ready(function () {
            showPrice();
            $('#imageGallery').lightSlider({
                gallery:true,
                item:1,
                vertical:true,
                verticalHeight:295,
                vThumbWidth:50,
                thumbItem:8,
                thumbMargin:4,
                slideMargin:0,
                enableDrag: false,
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });
        });


        // $('.category-overlay').on('click',  function () {
        //     let href = $(this).next().attr('href');
        //     window.location = href
        // })

        //
        // $(document).on('click', '.image-detail', function () {
        //     let src = $(this).attr('src');
        //     $('.image-avatar').attr('src', src);
        // })

        // var modal = document.getElementById("myModal");
        //
        // // Get the image and insert it inside the modal - use its "alt" text as a caption
        // var img = document.getElementById("myImg");
        // var modalImg = document.getElementById("img01");
        // var captionText = document.getElementById("caption");
        // img.onclick = function(){
        // modal.style.display = "block";
        // modalImg.src = this.src;
        // captionText.innerHTML = this.alt;
        // }
        //
        // // Get the <span> element that closes the modal
        // var span = document.getElementsByClassName("close")[0];
        //
        // // When the user clicks on <span> (x), close the modal
        // span.onclick = function() {
        // modal.style.display = "none";
        // }


        function showPrice(){
            dataPrice = $('#select-size').find(':selected').attr("data-price");
            $('#show-price').html(typeof dataPrice != 'undefined' ? dataPrice +  " VND" : 'Liên hệ '  );
        }

        $('#select-size').change(function () {
            showPrice();
        });
    </script>
  </body>
</html>
