@extends('furns.layout.master')

@section('content')

<div class="breadcrumb-area bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row breadcrumb_box  align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-left">
                        <h2 class="breadcrumb-title">Thông tin liên hệ</h2>
                    </div>
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list text-center text-md-right">
                            <li class="breadcrumb-item"><a href="{{ route('furn.home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Liên hệ</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--  Start  Team Section    -->
    <div class="team-section  bg-white">
        <!-- End Section Content Text Area -->
        <div class="team-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="0">
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Hot line</h6>
                                <span class="team-title">0703.552.222</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="200">
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Email</h6>
                                <span class="team-title">ngoclong18788@gmail.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="team-single" data-aos="fade-up" data-aos-delay="200">
                            <div class="team-content">
                                <h6 class="team-name font--bold mt-5">Địa chỉ</h6>
                                <span class="team-title">521 Minh Khai, Ha Noi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
