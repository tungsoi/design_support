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
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6" style="height: 100%; overflow: hidden !important; padding: 20px !important;">
                                <img id="myImg" class="image-avatar" src="{{ $product->avatar }}" alt="" style="max-height: 750px; width: 100%; max-width: 750px;">
                            </div>
                            <div class="col-lg-1" style="height: 100%; overflow: hidden !important; padding: 20px !important;">
                                @if ($product->pictures != null && is_array($product->pictures))
                                    @foreach ($product->pictures as $key => $picture)
                                        <img class="image-detail"
                                        src="{{ asset('uploads/'.$picture) }}" alt=""
                                        style="
                                        width: 100%;
                                        height: auto;
                                        margin-bottom: 10px;
                                        border: 1px solid #c7c7c7;
                                        cursor: pointer;
                                        display: block">
                                    @endforeach
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
                                    <div class="col-lg-12">
                                        <br>
                                        <h4 class="text-uppercase" style="font-weight: 400; color: rgb(172, 83, 83);">
                                            @if (Admin::user())
                                            {{ $price }}
                                            @else
                                            Liên hệ
                                            @endif
                                        </h4>
                                        <br>
                                    </div>
                                    <div class="col-lg-12">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
    <script>
        $('.category-overlay').on('click',  function () {
            let href = $(this).next().attr('href');
            window.location = href
        })

        $(document).on('click', '.image-detail', function () {
            let src = $(this).attr('src');
            $('.image-avatar').attr('src', src);
        })

        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }
    </script>
  </body>
</html>
