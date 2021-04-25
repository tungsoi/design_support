
    <!-- Product tab Area Start -->
    <div class="section product-tab-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center" data-aos="fade-up">
                    <div class="section-title mb-0">
                        <h2 class="title">Sản phẩm</h2>
                    </div>
                </div>

                <!-- Tab Start -->
                <div class="col-md-12 text-center mb-8" data-aos="fade-up" data-aos-delay="200">
                    <ul class="product-tab-nav nav justify-content-center">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-product-new-arrivals">Mới thêm</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-product-best-sellers">Bán chạy</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-product-sale-item">Đề xuất</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-product-on-sales">Đang giảm giá</a></li>
                    </ul>
                </div>
                <!-- Tab End -->
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content">
                        <!-- 1st tab start -->
                        <div class="tab-pane fade show active" id="tab-product-new-arrivals">
                            <div class="row">

                                @if (isset($products) && $products->count() > 0)

                                @foreach ($products as $key => $product)
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6" data-aos="fade-up" data-aos-delay="{{ ($key++)*100 }}">
                                        <!-- Single Prodect -->
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="shop-left-sidebar.html" class="image">
                                                    <img src="{{ asset('uploads/'.$product->avatar) }}" alt="Product" />
                                                    <img class="hover-image" src="{{ asset('uploads/'.$product->avatar) }}" alt="Product" />
                                                </a>
                                                {{-- <span class="badges">
                                                    <span class="new">New</span>
                                                </span> --}}
                                                <div class="actions">
                                                    <a href="#" class="action quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                            class="icon-size-fullscreen"></i></a>
                                                    {{-- <a href="compare.html" class="action compare" title="Compare"><i
                                                            class="icon-refresh"></i></a> --}}
                                                </div>
                                                <button title="Add To Cart" class=" add-to-cart">Thêm vào giỏ hàng</button>
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><a href="shop-left-sidebar.html">{{ $product->name }}</a></h5>
                                                <span class="price">
                                                    @if (Admin::user())
                                                        <span class="new" style="color: #e41c10">
                                                            {{
                                                                $product->properties->first()
                                                                ? number_format($product->properties->first()->price) . " VND"
                                                                : "Liên hệ"
                                                            }}
                                                        </span>
                                                    @else
                                                    <span>Liên hệ</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- 1st tab end -->
                        <!-- 2nd tab start -->
                        <div class="tab-pane fade" id="tab-product-best-sellers">

                        </div>
                        <!-- 2nd tab end -->
                        <!-- 3rd tab start -->
                        <div class="tab-pane fade" id="tab-product-sale-item"></div>
                        <!-- 3rd tab end -->
                        <!-- 4th tab start -->
                        <div class="tab-pane fade" id="tab-product-on-sales"></div>
                        <!-- 4th tab end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product tab Area End -->
