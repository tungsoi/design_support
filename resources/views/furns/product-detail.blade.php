@extends('furns.layout.master')

@section('content')

<div class="breadcrumb-area bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row breadcrumb_box  align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-left">
                        <h2 class="breadcrumb-title">Chi tiết sản phẩm</h2>
                    </div>
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <ul class="breadcrumb-list text-center text-md-right">
                            <li class="breadcrumb-item"><a href="{{ route('furn.home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('furn.product') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item active">{{ $product->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Details Area Start -->
<div class="product-details-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                <!-- Swiper -->
                <div class="swiper-container zoom-top">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide zoom-image-hover">
                            <img class="img-responsive m-auto" src="{{ asset('uploads/'.$product->avatar) }}" alt="" width="470" height="470">
                        </div>

                        @if ($product->pictures !== null && $product->pictures->count() > 0)
                        @foreach ($product->pictures as $picture)
                            <div class="swiper-slide zoom-image-hover">
                                <img class="img-responsive m-auto" src="{{ asset('uploads/'.$picture) }}" alt=""  width="470" height="470">
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="swiper-container zoom-thumbs slider-nav-style-1 small-nav mt-3 mb-3">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="img-responsive m-auto" src="{{ asset('uploads/'.$product->avatar) }}" alt=""  width="107" height="107">
                        </div>
                        @if ($product->pictures !== null && $product->pictures->count() > 0)
                        @foreach ($product->pictures as $picture)
                            <div class="swiper-slide">
                                <img class="img-responsive m-auto" src="{{ asset('uploads/'.$picture) }}" alt=""  width="107" height="107">
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-buttons">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
                <div class="product-details-content quickview-content">
                    <h2>{{ $product->code . " - " . $product->name}}</h2>
                    <p class="reference">Danh mục:<span> {{ $product->category->name }}</span></p>
                    <div class="pro-details-rating-wrap">
                        <div class="rating-product">
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                        </div>
                        <span class="read-review"><a class="reviews" href="#">Đọc đánh giá (1)</a></span>
                    </div>
                    <div class="pricing-meta">
                        <ul>
                            <li class="old-price not-cut">Liên hệ</li>
                        </ul>
                    </div>
                    {{-- <p class="quickview-para">{{ $product->description }}</p> --}}
                    <div class="pro-details-size-color d-flex">
                        <div class="pro-details-color-wrap">
                            <span>Màu sắc</span>
                            <div class="pro-details-color-content">
                                <ul>
                                    <li class="blue"></li>
                                    <li class="maroon active"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-size">
                            <span>Kích thước</span>
                            <select>
                                @if ($product->properties->count() > 0)
                                @foreach ($product->properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->size }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="pro-details-quality">
                        <div class="cart-plus-minus">
                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                        </div>
                        <div class="pro-details-cart">
                            <button class="add-cart btn btn-primary btn-hover-primary ml-4" href="#">  Thêm vào giỏ</button>
                        </div>
                    </div>
                    <div class="pro-details-wish-com">
                        {{-- <div class="pro-details-wishlist">
                            <a href="wishlist.html"><i class="ion-android-favorite-outline"></i>Add to
                                wishlist</a>
                        </div>
                        <div class="pro-details-compare">
                            <a href="compare.html"><i class="ion-ios-shuffle-strong"></i>Add to compare</a>
                        </div> --}}
                    </div>
                    <div class="pro-details-social-info">
                        <span>Share</span>
                        <div class="social-info">
                            <ul class="d-flex">
                                <li>
                                    <a href="#"><i class="ion-social-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-google"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="pro-details-policy">
                        <ul>
                            <li><img src="{{ asset('assets/furns/images/icons/policy.png') }}" alt="" /><span>An toàn, bảo mật sản phẩm</span></li>
                            <li><img src="{{ asset('assets/furns/images/icons/policy-2.png') }}" alt="" /><span>Giao hàng nhanh</span></li>
                            <li><img src="{{ asset('assets/furns/images/icons/policy-3.png') }}" alt="" /><span>Chế độ bảo hành, đổi trả</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- product details description area start -->
<div class="description-review-area pb-100px" data-aos="fade-up" data-aos-delay="200">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav">
                <a class="active"  data-bs-toggle="tab" href="#des-details1">Mô tả sản phẩm</a>
                <a data-bs-toggle="tab" href="#des-details2">Kích thước và vật liệu</a>
                <a data-bs-toggle="tab" href="#des-details3">Đánh giá</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-anotherinfo-wrapper">
                        {!! $product->description !!}
                    </div>
                </div>
                <div id="des-details2" class="tab-pane">
                    <div class="product-description-wrapper">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incididunt
                        </p>
                        <p>
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commo consequat. Duis aute irure dolor in reprehend in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                        </p>
                    </div>
                </div>
                <div id="des-details3" class="tab-pane">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="review-wrapper">
                                <div class="single-review">
                                    <div class="review-img">
                                        <img src="assets/images/review-image/1.png" alt="" />
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4>White Lewis</h4>
                                                </div>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                        <div class="review-bottom">
                                            <p>
                                                Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Suspendisse viverra ed viverra. Mauris ullarper euismod vehicula. Phasellus quam nisi, congue id nulla.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-review child-review">
                                    <div class="review-img">
                                        <img src="assets/images/review-image/2.png" alt="" />
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4>White Lewis</h4>
                                                </div>
                                                <div class="rating-product">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div>
                                        </div>
                                        <div class="review-bottom">
                                            <p>Vestibulum ante ipsum primis aucibus orci luctustrices posuere cubilia Curae Sus pen disse viverra ed viverra. Mauris ullarper euismod vehicula.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="ratting-form-wrapper pl-50">
                                <h3>Add a Review</h3>
                                <div class="ratting-form">
                                    <form action="#">
                                        <div class="star-box">
                                            <span>Your rating:</span>
                                            <div class="rating-product">
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                                <i class="ion-android-star"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="rating-form-style">
                                                    <input placeholder="Name" type="text" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="rating-form-style">
                                                    <input placeholder="Email" type="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="rating-form-style form-submit">
                                                    <textarea name="Your Review" placeholder="Message"></textarea>
                                                    <button class="btn btn-primary btn-hover-color-primary " type="submit" value="Submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
