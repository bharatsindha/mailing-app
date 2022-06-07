@extends('layouts.front.main')

@section('title', 'Register')

@section('content')
    <div class="breadcrumb-area pt-255 pb-170" style="background-image: url('https://via.placeholder.com/1920x856/BCBCBC/BCBCBC?text=text'); background-size: cover;">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h2>Register</h2>
            </div>
        </div>
    </div>
    <div class="login-register-area ptb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 ml-auto mr-auto">
                    <div class="row">
                        <div class="col-12">
                            @include('layouts.messages')
                        </div>
                    </div>

                    <div class="login-register-wrapper">
                        <div class="tab-content">
                            <div class="login-form-container">
                                <div class="login-form">
                                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                        {{ csrf_field() }}

                                        <input type="text" id="first_name" name="first_name" placeholder="First name" value="{{ old('first_name') }}" required autofocus>
                                        <input type="text" id="last_name" name="last_name" placeholder="Last name" value="{{ old('last_name') }}" required>
                                        <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                        <input type="password" id="password" name="password" placeholder="Password" value="{{ old('password') }}" required>
                                        <div class="button-box">
                                            <div class="login-toggle-btn mb-4">
                                                <a href="{{ route('login') }}">Already a member?</a>
                                            </div>
                                            <button type="submit" class="w-100 btn-style cr-btn"><span>Register</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection