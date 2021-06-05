<div class="menu" id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('furn.home') }}"><b>DESIGN SUPPORT</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="{{ route('furn.product') }}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                SẢN PHẨM
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">Phòng khách</a></li>
                <li><a class="dropdown-item" href="#">Phòng ngủ</a></li>
                <li><a class="dropdown-item" href="#">Phòng ăn</a></li>
                <li><a class="dropdown-item" href="#">Đèn</a></li>
                <li><a class="dropdown-item" href="#">Đồ decor</a></li>
              </ul>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('furn.about') }}">GIỚI THIỆU</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('furn.contact') }}">LIÊN HỆ</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.login') }}">ĐĂNG NHẬP</a>
            </li>
          </ul>
        </div>
    </nav>
</div>
