<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="page-category" class="">
        <div class="section pd-0" id="products" style="padding-top: 50px !important">
            <div class="container-fluid pd-0 bg-white">
                <div class="row pd-0" style="justify-content: center;">
                    @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <div class="col-12 col-md-6 col-lg-3 product-box" style="padding: 30px 30px 0px 30px !important; max-width: 320px;">
                            <div class="card">
                                <a href="{{ route('furn.product.detail', $product->id) }}" style="color: #646464 !important;">
                                    <img class="card-img-top" src="{{ $product->avatar }}" alt="Card image cap">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #646464">
                                        <a href="{{ route('furn.product.detail', $product->id) }}" style="color: #646464 !important;">
                                            {{ $product->code }}
                                        </a>
                                    </h5>
                                    <h6 class="card-title" style="color: #cd3333">
                                        <b>
                                            @if (Admin::user())
                                            {{ $product->price }}
                                            @else
                                            Liên hệ
                                            @endif
                                        </b>

                                        @if (Admin::user())
                                        <br> <br>
                                        <i style="color: #646464 !important">+ Phí vận chuyển</i>
                                        @endif
                                    </h6>
                                    {{-- <div class="row">
                                        <div class="col">
                                            <a href="#" class="btn btn-info btn-block btn-sm">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="#" class="btn btn-success btn-block btn-sm">
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else

                        <h3 style="color: #646464;
                        margin-top: 100px;">Chưa có sản phẩm</h3>
                    @endif
                </div>
            </div>
        </div>

        <br><br><br>
    </div>


    @include('furns.script')
  </body>
</html>
