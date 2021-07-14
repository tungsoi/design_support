<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="fullpage" class="">
        <div class="section pd-0" id="contact" style="padding-top: 50px !important;">
            <div class="container-fluid pd-0" style="">
                <div class="row">
                    {{-- <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <h5 style="font-weight: 400">Dịch vụ chăm sóc khách hàng của Design Support không chỉ hỗ trợ khách hàng khi có vấn đề phát sinh, mà còn lắng nghe và tiếp thu những ý kiến đóng góp của khách hàng. Chỉ cần liên hệ, chúng tôi sẵn sàng hỗ trợ bạn!</h5>
                        <br> <br> <br>
                        <p style="font-weight: bold">CÔNG TY TNHH DESIGN SUPPORT VIỆT NAM</p>
                        <p style="font-weight: 400; margin-bottom: 5px">Thứ 2 - Chủ nhật (10:00 - 19:00)</p>
                        <p style="font-weight: 400; margin-bottom: 5px">Tel: 0971.226.601</p>
                        <p style="font-weight: 400; margin-bottom: 5px">Email: info@designsupport.com</p>
                        <p style="font-weight: 400; margin-bottom: 5px">521 Bạch Mai, Hai Bà Trưng, Hà Nội</p>
                        <p class="font-italic mb-0 text-gray">&copy; 2021 DesignSupport@rec</p>
                    </div> --}}

                    <div class="col-lg-12">
                        <img src="{{ asset('assets/img/contact.png') }}" alt="" style="max-width: 100%; max-height: 100%; height: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('furns.script')
  </body>
</html>
