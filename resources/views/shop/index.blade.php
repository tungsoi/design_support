<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('admin.name') }} - {{ config('admin.sologan') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">{{ config('admin.name') }}</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">Giới thiệu</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#projects">Danh mục sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contacts">Liên hệ</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" data-toggle="modal" data-target="#cart">Giỏ hàng</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container d-flex h-100 align-items-center">
                <div class="mx-auto text-center">
                    <h1 class="mx-auto my-0 text-uppercase">{{ config('admin.name') }}</h1>
                    <br>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5" style="font-size: 30px !important">{{ config('admin.sologan') }}</h2>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="about-section text-center" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h2 class="text-white mb-4">Sự lựa chọn của bạn là ưu tiên hàng đầu và quan trọng nhất của chúng tôi</h2>
                        <p class="text-white-50">
                            Tất cả các sản phẩm đều được lựa chọn đảm bảo 3 tiêu chuẩn: vật liệu cao cấp, thiết kế tinh mỹ và chất lượng thi công hoàn hảo.
                            Hiện nay, Design Support có 3 dòng sản phẩm là Super Luxury, Luxury và Normal.
                            Dòng Super Luxury là các sản phẩm được nhập khẩu 100% từ các nước châu Âu như Pháp, Đức, Ý.
                            Nhiều sản phẩm thuộc dòng Super Luxury được chế tác hoàn toàn thủ công bởi các nghệ nhân lành nghề, các xưởng chế tác có lịch sử hàng trăm năm.
                            Dòng Luxury là các sản phẩm thiết kế theo phong cách châu Âu, được thi công tại Việt Nam, đáp ứng tiêu chuẩn chất lượng quốc tế.
                        </p>
                    </div>
                </div>
                <img class="img-fluid" src="{{ asset('assets/img/ipad.png') }}" alt="" />
            </div>
        </section>
        <section class="projects-section bg-light" id="new-products" style="padding-top: 80px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2 class="mb-4 header-row uppercase">Sản phẩm mới</h2>
                    </div>
                </div>
            </div>
            <div class="container-fluid" style="margin-top: 80px">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 mb-3">

                        <div class="container">
                            <div class="row blog">
                                <div class="col-md-12">
                                    <div id="blogCarousel" class="carousel slide" data-ride="carousel">

                                        <ol class="carousel-indicators">
                                            <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#blogCarousel" data-slide-to="1"></li>
                                            <li data-target="#blogCarousel" data-slide-to="2"></li>
                                        </ol>

                                        <!-- Carousel items -->
                                        <div class="carousel-inner">

                                            <div class="carousel-item active">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                </div>
                                                <!--.row-->
                                            </div>
                                            <!--.item-->

                                            <div class="carousel-item">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                </div>
                                                <!--.row-->
                                            </div>
                                            <!--.item-->

                                            <div class="carousel-item">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#">
                                                            <img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;">
                                                        </a>
                                                    </div>
                                                </div>
                                                <!--.row-->
                                            </div>
                                            <!--.item-->

                                        </div>
                                        <!--.carousel-inner-->
                                    </div>
                                    <!--.Carousel-->

                                </div>
                            </div>
                </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Projects-->
        <section class="projects-section bg-light" id="projects">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 category-item">
                        <div class="category-card card h-100"
                        style="">
                            <div class="category-overlay"></div>
                            <div class="card-body text-center">
                                <h4 class="text-uppercase m-0 category-name">
                                    Test
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 category-item">
                        <div class="category-card card h-100"
                        style="">
                            <div class="category-overlay"></div>
                            <div class="card-body text-center">
                                <h4 class="text-uppercase m-0 category-name">
                                    Test
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 category-item">
                        <div class="category-card card h-100"
                        style="">
                            <div class="category-overlay"></div>
                            <div class="card-body text-center">
                                <h4 class="text-uppercase m-0 category-name">
                                    Test
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 category-item">
                        <div class="category-card card h-100"
                        style="">
                            <div class="category-overlay"></div>
                            <div class="card-body text-center">
                                <h4 class="text-uppercase m-0 category-name">
                                    Test
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 category-item">
                        <div class="category-card card h-100"
                        style="">
                            <div class="category-overlay"></div>
                            <div class="card-body text-center">
                                <h4 class="text-uppercase m-0 category-name">
                                    Test
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="about-section text-center" id="contacts" style="padding-bottom: 50px; background: black !important; border-bottom: 1px dotted white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h2 class="text-white mb-4"> Chúng tôi cung cấp cho bạn chất lượng với sự tín nhiệm hoàn hảo</h2>
                        <p class="text-white-50">
                            <br>
                                Đưa bạn đến thế giới mơ ước của bạn với nhà thiết kế nội thất <br>
                                Sự hài lòng của bạn là cân nhắc hàng đầu của chúng tôi</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact-->
        <section class="contact-section bg-black" id="contacts">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0" style="color: black !important">Address</h4>
                                <hr class="my-4" />
                                <div class="small text-black-50">4923 Market Street, Orlando FL</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0" style="color: black !important">Email</h4>
                                <hr class="my-4" />
                                <div class="small text-black-50"><a href="#!">hello@yourdomain.com</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-mobile-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0" style="color: black !important">Phone</h4>
                                <hr class="my-4" />
                                <div class="small text-black-50">+1 (555) 902-8832</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Modal -->
        <div id="cart" class="modal fade" role="dialog" style="margin-top: 200px">
            <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align: center !important">Giỏ hàng</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-xs">Đặt hàng</button>
                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Đóng</button>
                </div>
            </div>

            </div>
        </div>

        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container">Copyright ©{{ config('admin.name') }} 2021</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>

        <script>
            $('#blogCarousel').carousel();
        </script>
    </body>
</html>
