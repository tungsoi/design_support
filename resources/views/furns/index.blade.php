<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="fullpage" class="">
        <div class="section" id="section0">
            <video id="myVideo" loop muted data-autoplay playsinline>
                <source src="{{ asset('assets/furn/video/intro.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="section" id="category-first">
            <div class="container-fluid" style="height: 100%; padding: 0px;">
                <div class="row" style="height: 100%">
                    @foreach ($categorie_row_1 as $category)
                    <div class="col-lg-6 col-md-12 col-sm-12 category category-link" style="
                        background-image: url({{ asset('uploads/'.$category->avatar) }});
                        background-repeat: no-repeat;
                        background-size: cover;"
                        data-link="{{ route('furn.product.product-by-category', $category->code) }}">
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
                            $class = "col-lg-4 col-md-6 col-sm-12 category category-link";
                            if ($key == 2) {
                                $class = "col-lg-4 col-md-12 col-sm-12 category category-link";
                            }
                        @endphp
                    <div class="{{ $class }}" style="
                        background-image: url({{ asset('uploads/'.$category->avatar) }});
                        background-repeat: no-repeat;
                        background-size: cover;"
                        data-link="{{ route('furn.product.product-by-category', $category->code) }}">
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
        <div class="section pd-0" id="products" style="padding-top: 50px !important">
            <div class="container-fluid pd-0 bg-white">
                <div class="row pd-0" style="justify-content: center;">
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
                                </h6>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="section pd-0" id="contact" style="padding-top: 50px !important;">
            <div class="container-fluid pd-0" style=" margin-top: 10% !important;">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <h5 style="font-weight: 400">Dịch vụ chăm sóc khách hàng của Design Support không chỉ hỗ trợ khách hàng khi có vấn đề phát sinh, mà còn lắng nghe và tiếp thu những ý kiến đóng góp của khách hàng. Chỉ cần liên hệ, chúng tôi sẵn sàng hỗ trợ bạn!</h5>
                        <br> <br> <br>
                        <p style="font-weight: bold; text-transform: uppercase">Công ty tư vấn thiết kế và cung cấp giải pháp ánh sáng ida lighting</p>
                        <p style="font-weight: 400; margin-bottom: 5px">Thứ 2 - Chủ nhật (10:00 - 19:00)</p>
                        <p style="font-weight: 400; margin-bottom: 5px">Tel: 0924.222.888</p>
                        <p style="font-weight: 400; margin-bottom: 5px">Email: idalighting.vn@gmail.com</p>
                        <p style="font-weight: 400; margin-bottom: 5px">153 Hà Huy Tập, Phường Nam hà, TP Hà Tĩnh</p>
                        <p class="font-italic mb-0 text-gray">&copy; 2021 DesignSupport@rec</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('furns.script')

    <script>
        $(document).on('click', '.category-link', function () {
            window.location.href = $(this).data('link');
        })
    </script>
  </body>
</html>
