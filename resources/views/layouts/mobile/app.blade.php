<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | PT Surya Pelangi Nusantara Sejahtera</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/font-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('mobile/css/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('mobile/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('mobile/css/styles.css') }}" />
    <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="shortcut icon" href="{{ asset('mobile/images/logo/168.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('mobile/images/logo/168.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <script>
        if (localStorage.toggled === "dark-theme") {
            document.documentElement.classList.add('dark-theme');
        }
    </script>
</head>
<body>
    @yield('header')
    <div class="app-content style-2">
        <div class="tf-container">
           @yield('content')
        </div>
    </div>

    @yield('menubar')
    <script type="text/javascript" src="{{ asset('mobile/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/lazysize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/jquery.nice-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/count-down.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/multiple-modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/nouislider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/rangle-slider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/js/main.js') }}"></script>
</body>
</html>
