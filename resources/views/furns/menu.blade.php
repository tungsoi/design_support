<style>
    /* ============ desktop view ============ */
    @media all and (min-width: 992px) {
        .dropdown-menu li{ position: relative; 	}
        .nav-item .submenu2{
            display: none;
            position: absolute;
            left:100%; top:-7px;
        }
        .nav-item .submenu-left{
            right:100%; left:auto;
        }
        .dropdown-menu > li:hover{ background-color: #646464 }
        .dropdown-menu > li:hover > .submenu{ display: block !important; }
    }
    /* ============ desktop view .end// ============ */

    /* ============ small devices ============ */
    @media (max-width: 991px) {
        .dropdown-menu .dropdown-menu{
            margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
        }
    }

    .raquo {
        float: right;
    }
</style>
<div class="menu" id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('furn.home') }}"><b>DESIGN SUPPORT</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown active" id="myDropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">SẢN PHẨM</a>
                    <ul class="dropdown-menu submenu">
                        @foreach ($category_menu as $category)
                            @if ($category->childrens->count() > 0)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('furn.product.product-by-category', $category->code) }}"
                                        data-bs-toggle="dropdown">
                                            {{ $category->name  }} &nbsp;
                                            <span class="raquo">&raquo; </span> &nbsp;
                                    </a>

                                    <ul class="submenu dropdown-menu submenu2">
                                        @foreach($category->childrens as $level2)
                                            @if ($level2->childrens->count() > 0)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('furn.product.product-by-category', $level2->code) }}">
                                                            {{ $level2->name }} &nbsp;
                                                        <span class="raquo">&raquo; </span> &nbsp;
                                                    </a>
                                                    <ul class="submenu dropdown-menu submenu2">
                                                        @foreach ($level2->childrens as $level3)
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('furn.product.product-by-category', $level3->code) }}">{{ $level3->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li><a class="dropdown-item"
                                                       href="{{ route('furn.product.product-by-category', $level2->code) }}">{{ $level2->name }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li> <a class="dropdown-item" href="{{ route('furn.product.product-by-category', $category->code) }}">{{ $category->name  }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('furn.about') }}">GIỚI THIỆU</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('furn.contact') }}">LIÊN HỆ</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.login') }}">
                        @if (Admin::user())
                            {{ Admin::user()->name }}
                        @else
                            ĐĂNG NHẬP
                        @endif

                    </a>
                </li>
            </ul>
        </div>
{{--        <div class="collapse navbar-collapse" id="navbarNavDropdown">--}}
{{--          <ul class="navbar-nav">--}}
{{--            <li class="nav-item dropdown active">--}}
{{--              <a class="nav-link dropdown-toggle" href="{{ route('furn.product') }}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                SẢN PHẨM--}}
{{--              </a>--}}
{{--              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                  @foreach ($category_menu as $category)--}}
{{--                    <li>--}}
{{--                        <a class="dropdown-item" href="{{ route('furn.product.product-by-category', $category['code']) }}">--}}
{{--                            {{ $category['name'] }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                  @endforeach--}}
{{--              </ul>--}}
{{--            </li>--}}
{{--
{{--          <li class="nav-item dropdown active">--}}
{{--                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">SẢN PHẨM</a>--}}
{{--                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                      @foreach ($category_menu as $category)--}}
{{--                          @if ($category->childrens->count() > 0)--}}
{{--                              <li class="dropdown">--}}
{{--                                  <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $category->name }}</a>--}}
{{--                                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                                      @foreach ($category->childrens as $level_2)--}}
{{--                                            <li><a href="#">{{ $level_2->name }}</a></li>--}}
{{--                                      @endforeach--}}
{{--                                      <li><a href="#">Another action</a></li>--}}
{{--                                      <li><a href="#">Something else here</a></li>--}}
{{--                                      <li class="dropdown">--}}
{{--                                          <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown3</a>--}}
{{--                                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                                              <li><a href="#">Action</a></li>--}}
{{--                                              <li><a href="#">Another action</a></li>--}}
{{--                                              <li><a href="#">Something else here</a></li>--}}
{{--                                          </ul>--}}
{{--                                      </li>--}}
{{--                                  </ul>--}}
{{--                              </li>--}}
{{--                          @else--}}

{{--                          @endif--}}
{{--                          <li @if ($category->childrens->count() > 0) class="nav-item dropdown" @endif>--}}
{{--                              <a class="dropdown-item" href="{{ route('furn.product.product-by-category', $category['code']) }}">--}}
{{--                                  {{ $category['name'] }}--}}
{{--                              </a>--}}
{{--                          </li>--}}
{{--                      @endforeach--}}
{{--                      <li class="nav-item dropdown"><a class="dropdown-item" href="#">Action</a></li>--}}
{{--                      <li><a href="#">Another action</a></li>--}}
{{--                      <li><a href="#">Something else here</a></li>--}}
{{--                      <li class="dropdown">--}}
{{--                          <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown2</a>--}}
{{--                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                              <li><a href="#">Action</a></li>--}}
{{--                              <li><a href="#">Another action</a></li>--}}
{{--                              <li><a href="#">Something else here</a></li>--}}
{{--                              <li class="dropdown">--}}
{{--                                  <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown3</a>--}}
{{--                                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                                      <li><a href="#">Action</a></li>--}}
{{--                                      <li><a href="#">Another action</a></li>--}}
{{--                                      <li><a href="#">Something else here</a></li>--}}
{{--                                  </ul>--}}
{{--                              </li>--}}
{{--                          </ul>--}}
{{--                      </li>--}}
{{--                  </ul>--}}
{{--              </li>--}}
{{--          </ul>--}}
{{--        </div>--}}
    </nav>
</div>

