<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | PT Surya Pelangi Nusantara Sejahtera </title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('theme_backoffice/assets/plugin/light-gallery/css/lightgallery.css') }}">
    <link rel="stylesheet" href="{{ asset('theme_backoffice/assets/css/timetracker.style.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <div id="timetracker-layout" class="theme-indigo">
        <div class="sidebar px-4 py-4 py-md-5 me-0">
            <div class="d-flex flex-column h-100">

                <a href="index.html" class="mb-0 brand-icon">
                    <span class="logo-icon">
                        <i class="icofont-stopwatch fs-2"></i>
                    </span>
                    <span class="logo-text">Absensi App</span>
                </a>

                @include('_admin.layouts.menu')
                <button type="button" class="btn btn-link sidebar-mini-btn text-light">
                    <span class="ms-2"><i class="icofont-bubble-right"></i></span>
                </button>

            </div>
        </div>
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            @include('_admin.layouts.header')
            <div class="body d-flex py-3">
                <div class="container-xxl">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('theme_backoffice/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('theme_backoffice/assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('theme_backoffice/assets/plugin/light-gallery/js/lightgallery.js') }}"></script>

    <script src="{{ asset('theme_backoffice/js/template.js') }}"></script>

    @stack('scripts')
</body>

</html>
