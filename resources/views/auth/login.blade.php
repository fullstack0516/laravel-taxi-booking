<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
</head>
<body>
<div id="wrapper">
    <header id="header-container" class="fullwidth">
        <div id="header">
            <div class="container">
                <div class="left-side">
                    <div id="logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                    </div>
                    <nav id="navigation">
                        <ul id="responsive">
                            <li>
                                <a href="{{ url('/') }}" @if(request()->is('/')) class="current" @endif>Home</a>
                            </li>
{{--                            <li>--}}
{{--                                <a href="#">Find a Driver</a>--}}
{{--                            </li>--}}
                            @guest
                                <li><a href="{{ route('login') }}" @if(request()->routeIs('login')) class="current" @endif>Login</a></li>
                                <li><a href="{{ route('register') }}" @if(request()->routeIs('register')) class="current" @endif>Register</a></li>
                            @endguest
                        </ul>
                    </nav>
                    <div class="clearfix"></div>
                </div>
                <div class="right-side">
                    <span class="mmenu-trigger">
                        <button class="hamburger hamburger--collapse" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
				    </span>
                </div>
            </div>
        </div>
    </header>
    <div class="clearfix"></div>
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Log In</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-5 offset-xl-3">
                <div class="login-register-page">
                    <div class="welcome-text">
                        <h3>We're glad to see you again!</h3>
                        <span>Don't have an account? <a href="{{ route('register') }}">Sign Up!</a></span>
                    </div>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="notification error closeable">
                                <p>{{ $error }}</p>
                                <a class="close">
                                </a>
                            </div>
                        @endforeach
                    @endif
                    <form method="post" id="login-form" action="{{ route('login') }}">
                        @csrf
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="email" class="input-text with-border" name="email" id="emailaddress" placeholder="Email Address" value="{{ old('email') }}" required/>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" value="{{ old('password') }}" required/>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                        @endif
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit">
                            Log In <i class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>
                    <div class="social-login-separator"><span>or</span></div>
                    <div class="social-login-buttons">
                        <a href="{{ route('social.redirect',['provider' => 'facebook']) }}" class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Log In via Facebook</a>
                        <a href="{{ route('social.redirect',['provider' => 'google']) }}" class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Log In via Google+</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="margin-top-70"></div>
    @include('partials.footer')
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/mmenu.min.js') }}"></script>
<script src="{{ asset('js/tippy.all.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/counterup.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
