<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Admin::title() }} @if($header) | {{ $header }}@endif</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    {!! Admin::css() !!}

    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}
</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">

@if($alert = config('admin.top_alert'))
    <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
        {!! $alert !!}
    </div>
@endif

<div class="wrapper">

    @include('admin::partials.header')

    @include('admin::partials.sidebar')

    <div class="content-wrapper" id="pjax-container">
        {!! Admin::style() !!}
        <div id="app">
        @yield('content')
        </div>
        {!! Admin::script() !!}
        {!! Admin::html() !!}
    </div>

    <div class="overlay-loading">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:#fff;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <defs>
              <path id="path" d="M50 15A15 35 0 0 1 50 85A15 35 0 0 1 50 15" fill="none"></path>
              <path id="patha" d="M0 0A15 35 0 0 1 0 70A15 35 0 0 1 0 0" fill="none"></path>
            </defs><g transform="rotate(0 50 50)">
            <use xlink:href="#path" stroke="#f1f2f3" stroke-width="3"></use>
            </g><g transform="rotate(60 50 50)">
            <use xlink:href="#path" stroke="#f1f2f3" stroke-width="3"></use>
            </g><g transform="rotate(120 50 50)">
            <use xlink:href="#path" stroke="#f1f2f3" stroke-width="3"></use>
            </g><g transform="rotate(0 50 50)">
            <circle cx="50" cy="15" r="9" fill="#e15b64">
              <animateMotion dur="1s" repeatCount="indefinite" begin="0s">
                <mpath xlink:href="#patha"></mpath>
              </animateMotion>
            </circle>
            </g><g transform="rotate(60 50 50)">
            <circle cx="50" cy="15" r="9" fill="#f8b26a">
              <animateMotion dur="1s" repeatCount="indefinite" begin="-0.16666666666666666s">
                <mpath xlink:href="#patha"></mpath>
              </animateMotion>
            </circle>
            </g><g transform="rotate(120 50 50)">
            <circle cx="50" cy="15" r="9" fill="#abbd81">
              <animateMotion dur="1s" repeatCount="indefinite" begin="-0.3333333333333333s">
                <mpath xlink:href="#patha"></mpath>
              </animateMotion>
            </circle>
            </g>
        </svg>
    </div>

</div>

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_);
</script>

<!-- REQUIRED JS SCRIPTS -->
{!! Admin::js() !!}

</body>
</html>
