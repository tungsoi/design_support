<!DOCTYPE html>
<html lang="vi">

<head>
    @include('furns.partials.head')
</head>

<body>
    @include('furns.partials.menu')
    @include('furns.partials.cart')
    @include('furns.partials.menu-mobile')

    <div class="main">
        @yield('content')
    </div>

    @include('furns.partials.footer')
    @include('furns.partials.script')
</body>

</html>
