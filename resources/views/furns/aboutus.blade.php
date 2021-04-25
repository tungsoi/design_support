@extends('furns.layout.master')

@section('content')

<div class="breadcrumb-area bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row breadcrumb_box  align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-left">
                        <h2 class="breadcrumb-title">Giới thiệu</h2>
                    </div>
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list text-center text-md-right">
                            <li class="breadcrumb-item"><a href="{{ route('furn.home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Giới thiệu</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- About Us Area Start -->
    <section class="about-area pb-100px pt-100px">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="about-content">
                        <div class="about-title" data-aos="fade-up">
                            <h2>Chào mừng bạn đến với Design Support</h2>
                        </div>
                        <p class="mb-6" data-aos="fade-up" data-aos-delay="200">
                            Được xây dựng trên nền tảng của sự sáng tạo, Design Support luôn không ngừng cố gắng, nỗ lực để giữ vững vị thế tiên phong của mình trên thị trường nội thất cao cấp tại Việt Nam hiện nay.

        Chúng tôi lấy tên Design Support với ý nghĩa sâu sắc về sự tiên phong, đi đầu trong mọi xu hướng cũng như mọi sự vận động của nhóm ngành thiết kế, thi công nội thất.

        Chữ “A” là con chữ đầu tiên của bảng chữ cái, cũng là mức cao nhất trong thang điểm khi chúng ta đánh giá một vấn đề gì đó, chữ “A” là biểu tượng cho vị trí thứ nhất trong mọi câu chuyện. Cái tên Design Support được lựa chọn với mục đích mang đến cho các gia đình những không gian sống sang trọng nhất, đẳng cấp nhất, khác biệt nhất và ấn tượng nhất.


                        </p>
                        <p data-aos="fade-up" data-aos-delay="300">
                            Để xứng đáng với sự tín nhiệm và niềm tin của quý vị, Design Support sẽ định hướng qua các dự án thiết kế, thi công nổi bật cùng những xu hướng mới nhất trên thế giới. Và muốn hoàn thành nhiệm vụ cao cả ấy, chính chúng tôi sẽ phải là những người đi đầu trong việc xây dựng những “chuẩn mực” trong quá trình hoạt động.

Ngay từ khi bắt đầu, chúng tôi đã mang trên mình sứ mệnh cao cả đó là tạo nên những giá trị sống đặc biệt cho từng gia đình, và hơn bất cứ điều gì đó chính là không gian nội thất. Chúng tôi cam kết mang đến cho quý vị những công trình sang trọng, hiện đại, “chất” và hoàn toàn khác biệt.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Area End -->
    <!-- Start Slill Progress -->
    <div class="progressbar-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="content" data-aos="fade-up" data-aos-delay="0">
                        <h4 class="title">TẦM NHÌN VÀ SỨ MỆNH
                        </h4>
                        <p class="title-desc">Một đơn vị được đánh giá là thành công khi nhận được nhiều nhất sự tín nhiệm, tin cậy và ủng hộ của khách hàng. Thấu hiểu một cách sâu sắc vấn đề đó, Design Support luôn truyền cảm hứng cho tất cả các thành viên trong tập thể, để bất cứ ai cũng luôn có được sự chăm chút sản phẩm đến từng chi tiết nhỏ nhất. Mọi giới hạn sẽ được phá vỡ để tạo nên những dịch vụ tốt nhất cho khách hàng:

                            Cam kết tiến độ công việc đạt chuẩn 100% theo hợp đồng với khách hàng
                            Lấy lợi ích của khách hàng làm giá trị cốt lõi cho mọi hoạt động của công ty
                            Chế độ bảo hành, bảo trì uy tín, tin cậy cho mọi sản phẩm
                            Đảm bảo tuyệt đối về chất lượng và nguồn gốc xuất xứ của vật liệu, cam kết hoàn trả 100% chi phí nếu như có bất cứ sai phạm nào.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-progress m-t-40">
                        <div class="skill-progressbar" data-aos="fade-up" data-aos-delay="0">
                            <h6 class="font--semi-bold m-b-15">NGUỒN NHÂN LỰC</h6>
                            <div class="line-progressbar" data-percentage="75" data-progress-color="#ff7004"></div>
                        </div>
                        <div class="skill-progressbar" data-aos="fade-up" data-aos-delay="200">
                            <h6 class="font--semi-bold m-b-15">CHẤT LƯỢNG DỊCH VỤ</h6>
                            <div class="line-progressbar" data-percentage="86" data-progress-color="#ff7004"></div>
                        </div>
                        <div class="skill-progressbar" data-aos="fade-up" data-aos-delay="400">
                            <h6 class="font--semi-bold m-b-15">NHÀ MÁY VÀ CÔNG NGHỆ</h6>
                            <div class="line-progressbar" data-percentage="97" data-progress-color="#ff7004"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Start  Team Section    -->
    <div class="team-section  bg-white">
        <!-- Start Section Content Text Area -->
        <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2 class="title">Nhân sự</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Content Text Area -->
        <div class="team-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="0">
                            <div class="team-img">
                                <img
                                class="img-fluid"
                                src="{{ asset('assets/furns/images/team/leader1.jpeg') }}"
                                alt="">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Mr. Thai Luxury</h6>
                                <span class="team-title">Giám đốc điều hành</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="200">
                            <div class="team-img">
                                <img class="img-fluid" src="{{ asset('assets/furns/images/team/leader2.jpeg') }}" alt="">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Mr. Le Ngoc Long</h6>
                                <span class="team-title">Giám đốc điều hành</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="200">
                            <div class="team-img">
                                <img class="img-fluid" src="{{ asset('assets/furns/images/team/leader3.jpeg') }}" alt="">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Mr. Dao Thanh Tung</h6>
                                <span class="team-title">Giám đốc CNTT</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="200">
                            <div class="team-img">
                                <img class="img-fluid" src="{{ asset('assets/furns/images/team/leader4.jpeg') }}" alt="">
                            </div>
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Mr. Le Ngoc Huyen</h6>
                                <span class="team-title">Giám đốc thương mại</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
