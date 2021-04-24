<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>{{ config('admin.name') . " | " . config('admin.sologan') }}</title>
<meta name="description" content="{{ config('admin.sologan') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<link rel="profile" href="https://gmpg.org/xfn/11">
<link rel="canonical" href="https://htmldemo.hasthemes.com/furns/" />

<!-- Open Graph (OG) meta tags are snippets of code that control how URLs are displayed when shared on social media  -->
<meta property="og:locale" content="vi" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ config('admin.name') . " | " . config('admin.sologan') }}" />
<meta property="og:url" content="https://designsupport.vn" />
<meta property="og:site_name" content="{{ config('admin.name') . " | " . config('admin.sologan') }}" />

<!-- For the og:image content, replace the # with a link of an image -->
<meta property="og:image" content="#" />
<meta property="og:description" content="F{{ config('admin.name') . " | " . config('admin.sologan') }}" />
<meta name="robots" content="noindex, follow" />

<!-- Add site Favicon -->
<link rel="icon" href="{{ asset('assets/furns/images/favicon/favicon.png') }}" sizes="32x32" />
<link rel="icon" href="{{ asset('assets/furns/images/favicon/favicon.png') }}" sizes="192x192" />
<link rel="apple-touch-icon" href="{{ asset('assets/furns/images/favicon/favicon.png') }}" />
<meta name="msapplication-TileImage" content="{{ asset('assets/furns/images/favicon/favicon.png') }}" />

<!-- Structured Data  -->
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "Design Support",
        "url": "https://designsupport.vn"
    }
</script>

<!-- vendor css (Bootstrap & Icon Font) -->
<link rel="stylesheet" href="{{ asset('assets/furns/css/vendor/simple-line-icons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/vendor/ionicons.min.css') }}" />

<!-- plugins css (All Plugins Files) -->
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/jquery-ui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/jquery.lineProgressbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/nice-select.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/venobox.css') }}" />

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<link rel="stylesheet" href="{{ asset('assets/furns/css/vendor/vendor.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/plugins/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/furns/css/style.min.css') }}">

<!-- Main Style -->
<link rel="stylesheet" href="{{ asset('assets/furns/css/style.css') }}" />
