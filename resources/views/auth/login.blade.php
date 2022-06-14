<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Primary Meta Tags -->
    <title>Mail - Sign in page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Volt CSS -->
    <link type="text/css" href="{{ asset('admin_template/css/volt.css') }}" rel="stylesheet">
</head>
<body>
<main>
    <!-- Section -->
    <section class="vh-lg-100 bg-soft d-flex align-items-center">
        <div class="">
            <div class="row justify-content-center form-bg-image" style="height: 100vh;">
                <div class="col-md-8 col-12 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('img/email-marketing-new.png') }}">
                </div>
                <div class="col-md-4 col-12 d-flex align-items-right justify-content-right">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="signin-inner w-100 fmxw-500">
                            @include('layouts.messages')
                        </div>
                    </div>
                    <div
                        class="signin-inner my-3 my-lg-0 bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100">
                        <div class="text-center mb-3">
                            <a href="{{ route('admin.dashboard') }}">
                                <img alt="" src="{{ asset('img/dark.svg') }}" style="width: 2rem; height: auto;"></a>
                        </div>
                        <h1 class="h3 text-center">Login</h1>

                        <form id="login_form" method="POST" action="{{ route('login') }}" class="mt-4">
                        {{ csrf_field() }}
                        <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="email">Your Email</label>
                                <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                <path
                                                    d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                        </span>
                                    <input type="text" name="email" id="email" class="form-control"
                                           placeholder="Email Address" required autofocus autocomplete="off">
                                </div>
                            </div>
                            <!-- End of Form -->
                            <div class="form-group">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="password">Your Password</label>
                                    <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        <input type="password" name="password" id="password" class="form-control"
                                               placeholder="Password" required autocomplete="off">
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="d-flex justify-content-between align-items-top mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember"
                                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label mb-0" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</body>
</html>
