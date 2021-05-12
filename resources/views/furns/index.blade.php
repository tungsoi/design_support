<!DOCTYPE html>
<html>
    @include('furns.head')
    <body>
    @include('furns.menu')
    <div class="main">
      <section class="bg-cover bg-center intro">
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
                    href="{{ route('furn.product.product-by-category', $category->code) }}"
                    data-lightbox="image-1"
                    data-title="My caption"
                    class="d-block"
                    style="">

                    <img src="{{ asset('uploads/'.$category->avatar) }}" alt="" style="width: 255px !important; height: 255px !important;">
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
                    href="{{ route('furn.product.product-by-category', $category->code) }}"
                    data-lightbox="image-1"
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
            <div class="container">
                <header class="text-center">
                  <h2 class="text-uppercase lined">Sản phẩm</h2>
                </header>
                <div class="row">
                    <div class="col-lg-12 text-center text-uppercase mb-5">
                        <a href="{{ route('furn.product') }}">Xem tất cả</a> <br>
                    </div>

                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="{{ $product->avatar }}" data-lightbox="image-1" data-title="{{ $product->name }}" class="d-block mb-1">
                                <img src="{{ $product->avatar }}" alt="..." class="img-fluid d-block mx-auto">
                            </a>
                            <p class="product-category-name text-center"><i>{{ $product->category->name }}</i></p>
                            <p class="product-name text-center">{{ $product->name }}</p>
                            <p class="product-price text-center">Liên hệ</p>
                        </div>
                    @endforeach
                </div>
              </div>
          </div>
        </div>
      </section>

      <section id="contact">
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="text-center mb-5">
              <h2 class="text-uppercase lined">Liên hệ</h2>
            </header>
            <div class="row">
              <div class="col-lg-12">
                <h5 style="font-weight: 400">Dịch vụ chăm sóc khách hàng của Design Support không chỉ hỗ trợ khách hàng khi có vấn đề phát sinh, mà còn lắng nghe và tiếp thu những ý kiến đóng góp của khách hàng. Chỉ cần liên hệ, chúng tôi sẵn sàng hỗ trợ bạn!</h5>
                <br>
                <p style="font-weight: bold">CÔNG TY TNHH DESIGN SUPPORT VIỆT NAM</p>
                <p style="font-weight: 400; margin-bottom: 5px">Thứ 2 - Chủ nhật (10:00 - 19:00)</p>
                <p style="font-weight: 400; margin-bottom: 5px">Tel: 0971.226.601</p>
                <p style="font-weight: 400; margin-bottom: 5px">Email: info@designsupport.com</p>
                <p style="font-weight: 400; margin-bottom: 5px">521 Bạch Mai, Hai Bà Trưng, Hà Nội</p>
              </div>

              <div class="col-lg-12">
                  <hr style="border-color: white"> <br>
                <form action="" class="contact-form">
                  <div class="row">
                    <div class="form-group col-lg-6">
                      <input id="firstName" type="text" name="fullname" placeholder="Họ và tên" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                      <input id="email" type="email" name="email" placeholder="Địa chỉ email" class="form-control">
                    </div>
                    <div class="form-group col-lg-12">
                      <textarea id="message" name="message" placeholder="Ghi chú" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-lg-12">
                      <button type="submit" class="btn btn-outline-primary w-100">Gửi thông tin</button>
                    </div>
                  </div>
                </form>
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

    <script src="{{ asset('assets/furn/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/furn/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/furn/onepage-scroll/jquery.onepage-scroll.min.js') }}"></script>
    <script src="{{ asset('assets/furn/lightbox2/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/furn/front.js') }}"></script>

    <script>
        $('.category-overlay').on('click',  function () {
            let href = $(this).next().attr('href');
            window.location = href
        })
    </script>
  </body>
</html>
