<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>@yield('title'){{ ' | ' . env('APP_NAME') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @section('stylesheets')
        <!-- Fontawesome -->
        <link type="text/css" href="{{ asset('admin_template/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

        <!-- Notyf -->
        <link type="text/css" href="{{ asset('admin_template/vendor/notyf/notyf.min.css') }}" rel="stylesheet">

        <!-- Theme CSS -->
        <link type="text/css" href="{{ asset('admin_template/css/theme.css') }}" rel="stylesheet">

        <!-- Custom style -->
        <link rel="stylesheet" href="{{ asset('admin_template/css/app-custom.css') }}">
    @show
</head>

<body>
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
        @csrf
    </form>

    @include('layouts.admin.header_responsive')

    <div class="container-fluid bg-soft">
        <div class="row">
            <div class="col-12">
                @include('layouts.admin.sidebar')

                <main class="content">
                    @include('layouts.admin.header')

                    @section('content')
                    @show

                    @include('layouts.admin.footer')
                </main>
            </div>
        </div>
    </div>

    @section('scripts')
        <!-- Core -->
        <script src="{{ asset('admin_template/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('admin_template/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

        <!-- Vendor JS -->
        <script src="{{ asset('admin_template/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>

        <!-- Slider -->
        <script src="{{ asset('admin_template/vendor/nouislider/distribute/nouislider.min.js') }}"></script>

        <!-- Jarallax -->
        <script src="{{ asset('admin_template/vendor/jarallax/dist/jarallax.min.js') }}"></script>

        <!-- Smooth scroll -->
        <script src="{{ asset('admin_template/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>

        <!-- Count up -->
        <script src="{{ asset('admin_template/vendor/countup.js/dist/countUp.umd.js') }}"></script>

        <!-- Notyf -->
        <script src="{{ asset('admin_template/vendor/notyf/notyf.min.js') }}"></script>

        <!-- Charts -->
        <script src="{{ asset('admin_template/vendor/chartist/dist/chartist.min.js') }}"></script>
        <script src="{{ asset('admin_template/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>

        <!-- Datepicker -->
        <script src="{{ asset('admin_template/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

        <!-- Simplebar -->
        <script src="{{ asset('admin_template/vendor/simplebar/dist/simplebar.min.js') }}"></script>

        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <!-- Theme JS -->
        <script src="{{ asset('admin_template/assets/js/theme.js') }}"></script>

        <!-- Custom JS -->
        <script src="{{ asset('admin_template/js/app-custom.js') }}"></script>
    @show
</body>

</html>