<!DOCTYPE html>
<html>
    @include('furns.head')
  <body>

    @include('furns.menu')
    @include('furns.submenu', [
        'from'  =>  'Trang chủ',
        'to'    =>  $product->code . " / " . $product->name
    ])
    <div class="main">
      <section class="bg-light products" style="margin-top: 50px;">
        <div class="d-flex h-100 align-items-center">
          <div class="container-fluid">
            <div class="content">
                <div class="row" style="margin: 0px 15px;">
                    <div class="col-lg-1">
                        @if ($product->pictures != null && is_array($product->pictures))
                            @foreach ($product->pictures as $picture)
                                <img src="{{ asset('uploads/'.$picture) }}" alt="" style="width: 100%; margin-bottom: 10px; border: 1px solid rgb(48, 47, 47); cursor: pointer">
                            @endforeach
                        @endif
                    </div>
                    <div class="col-lg-7" style="height: 100%; overflow: hidden;">
                        <img src="{{ $product->avatar }}" alt="" style="height: 90%; width: 100%">
                    </div>
                    <div class="col-lg-4">
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
