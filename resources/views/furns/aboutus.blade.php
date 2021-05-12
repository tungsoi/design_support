<!DOCTYPE html>
<html>
    @include('furns.head')
  <body>

    @include('furns.menu')
    @include('furns.submenu', [
        'from'  =>  'Trang chủ',
        'to'    =>  'Giới thiệu'
    ])
    <div class="main">

      <section class="bg-light products" style="margin-top: 50px;">
        <div class="d-flex h-100 align-items-center">
          <div class="container">
            <header class="text-center mb-5">
                <h2 class="text-uppercase lined">Giới thiệu về Design Support Việt Nam</h2>
            </header>
            <div class="row">
                <div class="col-lg-12">
                    <h5>CÔNG TY </h5>

                        <p>Công ty Design Support GmbH & Co.KG được thành lập năm 2007 tại Hamburg, Đức. Người sáng lập công ty là nhà thiết kế nội thất Quách Design Support, anh là người Đức gốc Việt có hơn 20 năm kinh nghiệm trong lĩnh vực thiết kế và cung cấp nội thất cao cấp. Tại Đức và Châu Âu, thương hiệu Design Support nổi tiếng với những thiết kế ấn tượng, sang trọng, đẳng cấp. Năm 2014, Design Support mở thêm văn phòng và showroom tại thành phố Hồ Chí Minh. Công ty TNHH Design Support Việt Nam mang đến những thiết kế giao thoa tinh tế giữa văn hoá phương Đông và phương Tây, chinh phục được những khách hàng khó tính nhất. Hiện tại, công ty Design Support chuyên thực hiện những dự án thiết kế-trang trí nội thất và cung cấp nội thất cho các biệt thự, căn hộ cá nhân và các dự án nhà hàng, khách sạn, bất động sản cao cấp.</p>
                        <p>Thông tin chi tiết:</p>
                        <p>Công ty TNHH MTV Design Support Việt Nam - giấy chứng nhận đăng ký doanh nghiệp số 0312788280 do Sở Kế Hoạch và Đầu Tư TP. HCM cấp lần đầu ngày 14/05/2014, đăng ký thay đổi lần thứ ba, ngày 18/11/2015.</p>
                            <p>Đại diện pháp luật: Design Support Patrick Quách</p>
                                <p>Địa chỉ trụ sở: 215A1 Nguyễn Văn Hưởng, Phường Thảo Điền, Quận 2, Thành phố Hồ Chí Minh</p>

                    <br>
                        <h5>THƯƠNG HIỆU ĐÃ ĐƯỢC KHẲNG ĐỊNH</h5>

                        Thương hiệu Design Support được khẳng định là một công ty thiết kế nội thất ấn tượng, uy tín và chuyên môn cao. Khách hàng tìm đến Design Support để tìm thấy một chuyên gia trong thiết kế và trang trí nội thất luôn sáng tạo những công trình độc đáo và ấn tượng. Mỗi công trình, Design Support và cộng sự tiếp nhận là một thử thách mới được hoàn thiện trên tình thần trách nhiệm cao.


                        ĐẶT HÀNG ONLINE CHƯA TỚI 1 PHÚT!

                        Nhằm tạo điều kiện cho khách hàng trải nghiệm những sản phẩm cao cấp nhất một cách thuận tiện, ngoài việc mua hàng trực tiếp tại showroom Design Support, hiện nay, quý khách có thể đặt hàng online tại website: www.thaicong.com


                        Tất cả những sản phẩm đều được lựa chọn bởi NTK nội thất Quách Design Support, đảm bảo đạt chuẩn về vật liệu cao cấp, thiết kế tinh xảo và chất lượng thi công hoàn hảo.

                        </p>
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
