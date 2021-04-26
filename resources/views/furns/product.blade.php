@extends('furns.layout.master')

@section('content')

<div class="breadcrumb-area bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row breadcrumb_box  align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-left">
                        <h2 class="breadcrumb-title">Danh sách sản phẩm</h2>
                    </div>
                    <div class="col-lg-6  col-md-6 col-sm-12">
                        <ul class="breadcrumb-list text-center text-md-right">
                            <li class="breadcrumb-item"><a href="{{ route('furn.home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Sản phẩm</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shop-category-area pb-100px pt-70px">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-lg-last col-md-12 order-md-first">
                <div class="shop-top-bar d-flex">
                    <p>Tổng số {{ $products->count() }} sản phẩm</p>
                    <!-- Left Side End -->
                    <!-- Right Side Start -->
                    <div class="select-shoing-wrap d-flex align-items-center">
                        <div class="shot-product">
                            <p>Sắp xếp theo:</p>
                        </div>
                        <div class="shop-select">
                            <select class="shop-sort">
                                <option data-display="Chọn">Chọn</option>
                                <option value="1"> Tên từ A đến Z</option>
                                <option value="2"> Tên từ Z đến A</option>
                                <option value="3"> Giá từ cao đến thấp</option>
                                <option value="4"> Giá từ thấp đến cao</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="shop-bottom-area">

                    <div class="row">
                        @if (isset($products) && $products->count() > 0)

                        @foreach ($products as $key => $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-6" data-aos="fade-up" data-aos-delay="{{ ($key++)*100 }}">
                                <!-- Single Prodect -->
                                <div class="product">
                                    <div class="thumb">
                                        <a href="{{ route('furn.product.detail', $product->id) }}" class="image">
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
                                        <h5 class="title"><a href="{{ route('furn.product.detail', $product->id) }}">{{ $product->name }}</a></h5>
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
                    <!--  Pagination Area Start -->
                    {{-- <div class="pro-pagination-style text-center mb-md-30px mb-lm-30px mt-6" data-aos="fade-up"> --}}
                        {{ $products->links() }}
                    {{-- </div> --}}
                    <!--  Pagination Area End -->
                </div>
                <!-- Shop Bottom Area End -->
            </div>
            <!-- Sidebar Area Start -->
            <div class="col-lg-3 order-lg-first col-md-12 order-md-last mb-md-60px mb-lm-60px">
                <div class="shop-sidebar-wrap">
                    <!-- Sidebar single item -->
                    <div class="sidebar-widget">
                        <div class="main-heading">
                            <h3 class="sidebar-title">Danh mục sản phẩm</h3>
                        </div>
                        <div class="sidebar-widget-category">
                            <ul>
                                <li><a href="#" class="selected">Tất cả</a></li>
                                @if (isset($categories) && $categories->count() > 0)
                                @foreach ($categories as $category)
                                <li><a href="#" class="">{{ $category->name }} <span>({{ $category->products->count() }})</span> </a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- Sidebar single item -->
                    <div class="sidebar-widget-group">
                        <h3 class="sidebar-title">Tìm kiếm</h3>
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">Giá sản phẩm</h4>
                            <div class="price-filter">
                                <div class="price-slider-amount">
                                    <input type="text" id="amount" class="p-0 h-auto lh-1" name="price" placeholder="Add Your Price" />
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                        <!-- Sidebar single item -->
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title mt-5">Kích thước</h4>
                            <div class="sidebar-widget-list">
                                <ul>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" /> <a href="#">Lớn <span>(4)</span> </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value="" /> <a href="#">Vừa
                                                <span>(4)</span></a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value="" /> <a href="#">Nhỏ <span>(4)</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar single item -->
                        <div class="sidebar-widget no-cba">
                            <h4 class="pro-sidebar-title">Màu sắc</h4>
                            <div class="sidebar-widget-list">
                                <ul>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" /> <a href="#">Grey<span>(2)</span> </a>
                                            <span class="checkmark grey"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value="" /> <a href="#">White<span>(4)</span></a>
                                            <span class="checkmark white"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value="" /> <a href="#">Black<span>(4)</span>
                                            </a>
                                            <span class="checkmark black"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value="" /> <a href="#">Camel<span>(4)</span>
                                            </a>
                                            <span class="checkmark camel"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar single item -->
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">Brand</h4>
                            <div class="sidebar-widget-list">
                                <ul>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" /> <a href="#">Studio Design<span>(10)</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value="" /> <a href="#">Graphic
                                                Corner<span>(7)</span></a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar single item -->
                    <div class="sidebar-widget tag">
                        <div class="main-heading">
                            <h3 class="sidebar-title mt-3">Tags</h3>
                        </div>
                        <div class="sidebar-widget-tag">
                            <ul>
                                <li><a href="#">All</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Chair</a></li>
                                <li><a href="#">Decoration</a></li>
                                <li><a href="#">Furniture</a></li>
                                <li><a href="#">Sofa</a></li>
                                <li><a href="#">Table</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Sidebar single item -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
