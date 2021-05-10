<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Screen - Multipurpose Template By Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets/furn/bootstrap/css/bootstrap.min.css') }}">
    <!-- Google fonts-->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cardo:400,400i"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
    <!-- Lightbox-->
    <link rel="stylesheet" href="{{ asset('assets/furn/lightbox2/css/lightbox.min.css') }}">
    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Parallax-->
    <link rel="stylesheet" href="{{ asset('assets/furn/onepage-scroll/onepage-scroll.css') }}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets/furn/css/style.sea.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets/furn/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script><![endif]-->

        <style>

            html, body {
                width: 100%;
                overflow-x: hidden;
                font: 300 14px 'Montserrat';
                color: #fff;
                position: relative;
                line-height: 1.6;
                background: #111;
            }
            #myVideo {
                position: absolute;
                width: 100% !important;
                top: 0;
                left: 0;
            }
            .hero {
                background: none !important;
            }
            .logo {
                max-width: 150px;
            }
            .menu {
              position: fixed;
              top: 0;
              left: 0;
              z-index: 200000;
              width: 100%;
              background: #000;
              border-color: #D0D0D0;
              height: 55px;
            }
            .menu .navbar {
              width: 100%;
              max-width: 1440px;
              margin-left: auto;
              margin-right: auto;
              height: 100%;
            }
            .menu .nav-item a {
              display: inline-block;
              font-size: 13px;
              font-weight: 600;
              color: #999 !important;
              position: relative;
              z-index: 10;
            }
            .menu .nav-item a:hover {
              color: white !important;
            }
            .menu .nav-item {
              margin-left: 30px;
            }
            .navbar-nav .active  a {
              color: white !important;
            }
            .brand {
              font-size: 32px !important;
              font-weight: 400 !important;
              color: white !important;
              margin-right: 40px;
            }
            section {
                padding: 0px !important;
            }
            .category {
                padding: 0px !important;
                margin: 0px !important;
                height: 100% !important;
                cursor: pointer;
                overflow: hidden;
            }
            .category img {
                /* width: 100%; */
                height: 100%;
                transition: transform 1s;
                margin-left: -10%;
            }

            .category a {
                width: 100%;
                height: 100%;
            }
            .category-head .row {
                position: absolute !important;
                height: 100% !important;
                padding: 0px !important;
                margin: 0px !important;
                width: 100%;
            }
            .category-overlay {
              position: absolute;
              width: 100%;
              height: 100%;
              background: black;
              z-index: 2;
              opacity: 0.5;
              -webkit-transition: opacity 0.5s ease-in-out;
              -moz-transition: opacity 0.5s ease-in-out;
              -ms-transition: opacity 0.5s ease-in-out;
              -o-transition: opacity 0.5s ease-in-out;
              transition: opacity 0.5s ease-in-out;
            }
            .category:hover .category-overlay{
              opacity: 0;
            }
            .category:hover img{
              transform: scale(1.1);
            }
            .category-text {
              position: absolute;
              z-index: 3;
              left: 20px;
              bottom: 50px;
              text-transform: uppercase;
            }

            .products {
              background-color: white !important;
              color: #999 !important;
            }
            .product-item img {
                width: 90%;
                height: auto;
                max-height: 300px;
            }

            .product-item {
                height: 100% !important;
                margin-bottom: 50px !important;
            }
        </style>
  </head>
  <body>
    <div class="menu">
      <nav class="navbar navbar-expand-lg ">
        <div class="collapse navbar-collapse" id="navbarNav">
          <a class="nav-link brand" href="#">DESIGN SUPPORT <span class="sr-only">(current)</span></a>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#">SẢN PHẨM <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">GIỚI THIỆU</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">LIÊN HỆ</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <div class="main">
      <section class="bg-cover bg-center hero">
        <video autoplay muted loop id="myVideo">
            <source src="{{ asset('assets/furn/video/intro.mp4') }}" type="video/mp4">
        </video>
      </section>
      <section class="category-head">
        <div class="row">
            @foreach ($categorie_row_1 as $category)
            <div class="col-lg-6 col-md-6 category">
                <div class="category-overlay"></div>
                <a
                    href="#"
                    data-lightbox="image-1"
                    data-title="My caption"
                    class="d-block"
                    style="">

                    <img src="{{ asset('uploads/'.$category->avatar) }}" alt="">
                </a>
                <div class="category-text">
                  <h1>{{ $category->name }}</h2>
                  <h3 style="font-weight: 400">Tìm hiểu thêm</h3>
                </div>
            </div>
            @endforeach
        </div>
      </section>
      <section class="category-head">
        <div class="row">
            @foreach ($categorie_row_2 as $category)
            <div class="col-lg-4 col-md-4 category">
                <div class="category-overlay"></div>
                <a
                    href="#"
                    data-lightbox="image-1"
                    data-title="My caption"
                    class="d-block"
                    style="">

                    <img src="{{ asset('uploads/'.$category->avatar) }}" alt="">
                </a>
                <div class="category-text">
                  <h2>{{ $category->name }}</h2>
                  <p>Tìm hiểu thêm</p>
                </div>
            </div>
            @endforeach
        </div>
      </section>
      <section class="bg-light products">
        <div class="d-flex h-100 align-items-center">
          <div class="container-fluid">
            <header class="mb-5 text-center">
              <h2 class="text-uppercase lined">Sản phẩm</h2>
              <a href="" class="text-uppercase">xem tất cả</a>
            </header>
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-2 mb-4 product-item">
                                <img src="{{ $product->avatar }}" alt="">
                                <br> <br>
                                <i><h5 class="" style="font-weight: 400">Đèn</h5></i>
                                <h4 class="text-uppercase lined-compact">Đèn chùm hiện đại</h4>
                                <h5 class="text-mted">10.000.000 VND</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="text-center mb-5">
              <h2 class="text-uppercase lined">Liên hệ</h2>
            </header>
            <div class="row">
              <div class="col-lg-6">
                <form action="" class="contact-form">
                  <div class="row">
                    <div class="form-group col-lg-6">
                      <label for="firstName">Họ *</label>
                      <input id="firstName" type="text" name="firstname" placeholder="Enter your firstname" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                      <label for="lastName">Tên và tên đệm *</label>
                      <input id="lastName" type="text" name="lastname" placeholder="Enter your lastname" class="form-control">
                    </div>
                    <div class="form-group col-lg-12">
                      <label for="email">Địa chỉ email *</label>
                      <input id="email" type="email" name="email" placeholder="Enter your email" class="form-control">
                    </div>
                    <div class="form-group col-lg-12">
                      <label for="message">Ghi chú *</label>
                      <textarea id="message" name="message" placeholder="Enter your message" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-lg-12">
                      <button type="submit" class="btn btn-outline-primary w-100">Gửi thông tin</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-6">
                <p>Hotline: 0345.513.889</p>
                <p>Địa chỉ: 521 Minh Khai, Hà Nội</p>
                <p>Email: designsupport-noreply@gmail.com</p>
              </div>
            </div>
            <footer class="py-5 mt-5">
              <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                  <p class="font-italic mb-0 text-gray">&copy; 2021 DesignSupport@rec</p>
                </div>
              </div>
            </footer>
          </div>
        </div>
      </section>
    </div>

    <!-- JavaScript files-->
    <script src="{{ asset('assets/furn/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/furn/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/furn/onepage-scroll/jquery.onepage-scroll.min.js') }}"></script>
    <script src="{{ asset('assets/furn/lightbox2/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/furn/front.js') }}"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>
