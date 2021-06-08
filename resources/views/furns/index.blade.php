<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="fullpage" class="">
        {{-- <div class="section" id="section0">
            <video id="myVideo" loop muted data-autoplay playsinline>
                <source src="{{ asset('assets/furn/video/intro.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="section" id="category-first">
            <div class="container-fluid" style="height: 100%; padding: 0px;">
                <div class="row" style="height: 100%">
                    @foreach ($categorie_row_1 as $category)
                    <div class="col-lg-6 col-md-12 col-sm-12 category" style="
                        background-image: url({{ asset('uploads/'.$category->avatar) }});
                        background-repeat: no-repeat;
                        background-size: cover;
                    ">
                        <div class="category-overlay"></div>
                        <div class="category-text">
                        <h2>{{ $category->name }}</h2>
                        <h4 style="font-weight: 400">Tìm hiểu thêm</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="section" id="category-second">
            <div class="container-fluid"  style="height: 100%; padding: 0px;">
                <div class="row" style="height: 100%">
                    @foreach ($categorie_row_2 as $key => $category)
                        @php
                            $class = "col-lg-4 col-md-6 col-sm-12 category";
                            if ($key == 2) {
                                $class = "col-lg-4 col-md-12 col-sm-12 category";
                            }
                        @endphp
                    <div class="{{ $class }}" style="
                        background-image: url({{ asset('uploads/'.$category->avatar) }});
                        background-repeat: no-repeat;
                        background-size: cover;
                    ">
                        <div class="category-overlay"></div>
                        <div class="category-text">
                        <h2>{{ $category->name }}</h2>
                        <h4 style="font-weight: 400">Tìm hiểu thêm</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> --}}
        <div class="section pd-0" id="products">
            <div class="container-fluid pd-0 bg-white">

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <center>
                            {{ $products->links() }}
                        </center>
                    </div>
                </div>
                <div class="row pd-0" style="justify-content: center;">
                    @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-3 product-box" style="padding: 30px 30px 0px 30px !important; max-width: 320px;">
                        <div class="card">
                            <img class="card-img-top" src="{{ $product->avatar }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #646464">{{ $product->code . "-" . $product->name }}</h5>
                                <h6 class="card-title" style="color: #cd3333"><b>10,000,000 VND</b></h6>
                                <div class="row">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    @include('furns.script')
  </body>
</html>
