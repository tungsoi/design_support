<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="fullpage" class="">
        <div class="section pd-0" id="products">
            <div class="container-fluid pd-0 bg-white h-100" style="margin-top: 70px;">
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
                    <div class="col-lg-6" style="height: 100%; overflow: hidden !important; padding: 20px !important;">
                        <img class="image-avatar" src="{{ $product->avatar }}" alt="" style="max-height: 750px; width: 100%;">
                    </div>
                    <div class="col-lg-1" style="height: 100%; overflow: hidden !important; padding: 20px !important;">
                        @if ($product->pictures != null && is_array($product->pictures))
                            @foreach ($product->pictures as $key => $picture)
                                <img class="image-detail"
                                src="{{ asset('uploads/'.$picture) }}" alt=""
                                style="
                                width: 85px;
                                height: 85px;
                                margin-bottom: 10px;
                                border: 1px solid #c7c7c7;
                                cursor: pointer;">
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
                                <h4 class="text-uppercase" style="font-weight: 400; color: rgb(172, 83, 83);">Liên hệ</h4>
                            </div>
                            <div class="col-lg-12">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
  </body>
</html>
