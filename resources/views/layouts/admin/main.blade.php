<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>@yield('title'){{ ' | ' . env('APP_NAME') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@section('stylesheets')
    <!-- Sweet Alert -->
        <link type="text/css" href="{{ asset('admin_template/vendor/sweetalert2/dist/sweetalert2.min.css') }}"
              rel="stylesheet">
        <!-- Notyf -->
        <link type="text/css" href="{{ asset('admin_template/vendor/notyf/notyf.min.css') }}" rel="stylesheet">
        <!-- Volt CSS -->
        <link type="text/css" href="{{ asset('admin_template/css/volt.css') }}" rel="stylesheet">

        <link type="text/css" href="{{ asset('admin_template/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
        <style>
            .sidebar-inner {
                overflow-y: inherit;
            }
        </style>
    @show
</head>
<body>
<form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
    @csrf
</form>
@include('layouts.admin.header_responsive')
@include('layouts.admin.sidebar')
<main class="content">
    @include('layouts.admin.header')
    @section('content')
    @show
    @include('layouts.admin.footer')
</main>
@section('scripts')
    <!-- Core -->
    <script src="{{ asset('admin_template/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin_template/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ asset('admin_template/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>
    <!-- Slider -->
    {{--<script src="{{ asset('admin_template/vendor/nouislider/distribute/nouislider.min.js') }}"></script>--}}
    <!-- Smooth scroll -->
    <script src="{{ asset('admin_template/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
    <!-- Charts -->
    {{--<script src="{{ asset('admin_template/vendor/chartist/dist/chartist.min.js') }}"></script>--}}
    {{--<script
        src="{{ asset('admin_template/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>--}}
    <!-- Datepicker -->
    <script src="{{ asset('admin_template/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
    <!-- Sweet Alerts 2 -->
    <script src="{{ asset('admin_template/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <!-- Notyf -->
    <script src="{{ asset('admin_template/vendor/notyf/notyf.min.js') }}"></script>
    <!-- Simplebar -->
    <script src="{{ asset('admin_template/vendor/simplebar/dist/simplebar.min.js') }}"></script>
    <!-- Volt JS -->
    <script src="{{ asset('admin_template/assets/js/volt.js') }}"></script>

    <script src="{{ asset('admin_template/vendor/fontawesome/js/all.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    @include('layouts.messages')
@show
</body>
</html>
