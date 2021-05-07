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
                margin-left: -50%;
            }

            .category a {
                width: 100%;
                height: 100%;
            }
            #category .row {
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
      <section id="category">
        <div class="row">
            @foreach ($categories as $category)
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
                  <h2>{{ $category->name }}</h2>
                  <p>Tìm hiểu thêm</p>
                </div>
            </div>
            @endforeach
        </div>
      </section>
      <section class="bg-light">
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="mb-5 text-center">
              <h2 class="text-uppercase lined">Sản phẩm</h2>
            </header>
            <div class="row text-center">
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon mb-3"><i class="fas fa-desktop"></i></div>
                <h4 class="text-uppercase lined lined-compact">Web design</h4>
                <p class="text-mted">Fifth abundantly made Give sixth hath. Cattle creature i be don't them.</p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon mb-3"><i class="fas fa-print"></i></div>
                <h4 class="text-uppercase lined lined-compact">Print</h4>
                <p class="text-mted">Advantage old had otherwise sincerity dependent additions. It in adapted natural.</p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon mb-3"><i class="fas fa-globe-americas"></i></div>
                <h4 class="text-uppercase lined lined-compact">SEO and SEM</h4>
                <p class="text-mted">Am terminated it excellence invitation projection as. She graceful shy.</p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon mb-3"><i class="far fa-lightbulb"></i></div>
                <h4 class="text-uppercase lined lined-compact">consulting</h4>
                <p class="text-mted">Fifth abundantly made Give sixth hath. Cattle creature i be don't them.</p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon mb-3"><i class="far fa-envelope"></i></div>
                <h4 class="text-uppercase lined lined-compact">Email marketing</h4>
                <p class="text-mted">Advantage old had otherwise sincerity dependent additions. It in adapted natural.</p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="icon mb-3"><i class="fas fa-user"></i></div>
                <h4 class="text-uppercase lined lined-compact">UI &amp; UX</h4>
                <p class="text-mted">Am terminated it excellence invitation projection as. She graceful shy.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="text-center mb-5">
              <h2 class="text-uppercase lined">Portfolio</h2>
            </header>
            <div class="row">
              <div class="col-lg-12 text-center">
                <p>You can make also a portfolio or image gallery.</p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4"><a href="{{ asset('assets/furn/img/portfolio-1.jpg') }}" data-lightbox="image-1" data-title="My caption" class="d-block mb-1"><img src="{{ asset('assets/furn/img/portfolio-1.jpg') }}" alt="..." class="img-fluid d-block mx-auto"></a></div>
              <div class="col-lg-4 col-md-6 mb-4"><a href="{{ asset('assets/furn/img/portfolio-2.jpg') }}" data-lightbox="image-1" data-title="My caption" class="d-block mb-1"><img src="{{ asset('assets/furn/img/portfolio-2.jpg') }}" alt="..." class="img-fluid d-block mx-auto"></a></div>
              <div class="col-lg-4 col-md-6 mb-4"><a href="{{ asset('assets/furn/img/portfolio-3.jpg') }}" data-lightbox="image-1" data-title="My caption" class="d-block mb-1"><img src="{{ asset('assets/furn/img/portfolio-3.jpg') }}" alt="..." class="img-fluid d-block mx-auto"></a></div>
              <div class="col-lg-4 col-md-6 mb-4"><a href="{{ asset('assets/furn/img/portfolio-4.jpg') }}" data-lightbox="image-1" data-title="My caption" class="d-block mb-1"><img src="{{ asset('assets/furn/img/portfolio-4.jpg') }}" alt="..." class="img-fluid d-block mx-auto"></a></div>
              <div class="col-lg-4 col-md-6 mb-4"><a href="{{ asset('assets/furn/img/portfolio-5.jpg') }}" data-lightbox="image-1" data-title="My caption" class="d-block mb-1"><img src="{{ asset('assets/furn/img/portfolio-5.jpg') }}" alt="..." class="img-fluid d-block mx-auto"></a></div>
              <div class="col-lg-4 col-md-6 mb-4"><a href="{{ asset('assets/furn/img/portfolio-6.jpg') }}" data-lightbox="image-1" data-title="My caption" class="d-block mb-1"><img src="{{ asset('assets/furn/img/portfolio-6.jpg') }}" alt="..." class="img-fluid d-block mx-auto"></a></div>
            </div>
          </div>
        </div>
      </section>
      <section class="bg-gray">
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="text-center mb-5">
              <h2 class="text-uppercase lined">Text page</h2>
            </header>
            <div class="row">
              <div class="col-lg-6">
                <p>Able an hope of body. Any nay shyness article matters own removal nothing his forming. Gay own additions education satisfied the perpetual. If he cause manor happy. Without farther she exposed saw man led. Along on happy could cease green oh.</p>
                <p>Betrayed cheerful declared end and. Questions we additions is extremely incommode. Next half add call them eat face. Age lived smile six defer bed their few. Had admitting concluded too behaviour him she. Of death to or to being other.</p>
              </div>
              <div class="col-lg-6">
                <p>Effects present letters inquiry no an removed or friends. Desire behind latter me though in. Supposing shameless am he engrossed up additions. My possible peculiar together to. Desire so better am cannot he up before points. Remember mistaken opinions it pleasure of debating. Court front maids forty if aware their at. Chicken use are pressed removed.</p>
                <p>Saw yet kindness too replying whatever marianne. Old sentiments resolution admiration unaffected its mrs literature. Behaviour new set existence dashwoods. It satisfied to mr commanded consisted disposing engrossed. Tall snug do of till on easy. Form not calm new fail.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section>
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="text-center mb-5">
              <h2 class="text-uppercase lined">Contact</h2>
            </header>
            <div class="row">
              <div class="col-lg-6">
                <form action="" class="contact-form">
                  <div class="row">
                    <div class="form-group col-lg-6">
                      <label for="firstName">Your firstname *</label>
                      <input id="firstName" type="text" name="firstname" placeholder="Enter your firstname" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                      <label for="lastName">Your lastname *</label>
                      <input id="lastName" type="text" name="lastname" placeholder="Enter your lastname" class="form-control">
                    </div>
                    <div class="form-group col-lg-12">
                      <label for="email">Your email *</label>
                      <input id="email" type="email" name="email" placeholder="Enter your email" class="form-control">
                    </div>
                    <div class="form-group col-lg-12">
                      <label for="message">Your message for us *</label>
                      <textarea id="message" name="message" placeholder="Enter your message" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-lg-12">
                      <button type="submit" class="btn btn-outline-primary w-100">Send message</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-6">
                <p>Effects present letters inquiry no an removed or friends. Desire behind latter me though in. Supposing shameless am he engrossed up additions. My possible peculiar together to. Desire so better am cannot he up before points. Remember mistaken opinions it pleasure of debating. Court front maids forty if aware their at. Chicken use are pressed removed.</p>
                <p>Able an hope of body. Any nay shyness article matters own removal nothing his forming. Gay own additions education satisfied the perpetual. If he cause manor happy. Without farther she exposed saw man led. Along on happy could cease green oh.</p>
                <ul class="mb-0 list-inline text-center">
                  <li class="list-inline-item"><a href="#" class="social-link social-link-facebook"><i class="fab fa-facebook-f"></i></a></li>
                  <li class="list-inline-item"><a href="#" class="social-link social-link-twitter"><i class="fab fa-twitter"></i></a></li>
                  <li class="list-inline-item"><a href="#" class="social-link social-link-google-plus"><i class="fab fa-google-plus-g"></i></a></li>
                  <li class="list-inline-item"><a href="#" class="social-link social-link-instagram"><i class="fab fa-instagram"></i></a></li>
                  <li class="list-inline-item"><a href="#" class="social-link social-link-email"><i class="fas fa-envelope"></i></a></li>
                </ul>
              </div>
            </div>
            <footer class="py-5 mt-5">
              <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                  <p class="font-italic mb-0 text-gray">&copy; 2019 Your name/company goes here</p>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                  <p class="font-italic mb-0 text-gray">&copy; Template by <a href="https://bootstrapious.com/p/big-bootstrap-tutorial" class="text-gray">Bootstrapious</a></p>
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
