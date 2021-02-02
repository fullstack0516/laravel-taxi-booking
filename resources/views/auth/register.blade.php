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
                    <h2>Register</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-5 offset-xl-3">
                <div class="login-register-page">
                    <div class="welcome-text">
                        <h3 style="font-size: 26px;">Let's create your account!</h3>
                        <span>Already have an account? <a href="{{ route('login') }}">Log In!</a></span>
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
                    <form method="post" action="{{ route('register') }}" id="register-form">
                        @csrf
                        <div class="account-type">
                            <div>
                                <input type="radio" name="role" value="customer" id="employer-radio" class="account-type-radio" checked/>
                                <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Customer</label>
                            </div>
                            <div>
                                <input type="radio" name="role" value="driver" id="freelancer-radio" class="account-type-radio"/>
                                <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Driver</label>
                            </div>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-feather-user"></i>
                            <input type="text" class="input-text with-border" name="name" id="user_name" placeholder="User Name" value="{{ old('name') }}" required/>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="text" class="input-text with-border" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" required/>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-feather-user"></i>
                            <input type="text" class="input-text with-border" name="first_name" id="first_name" placeholder="First Name" value="{{ old('first_name') }}" required/>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-feather-user"></i>
                            <input type="text" class="input-text with-border" name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required/>
                        </div>
                        <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password" id="password-register" placeholder="Password" required/>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password_confirmation" id="password-repeat-register" placeholder="Confirm Password" required/>
                        </div>
                        <div>
                            <select name="city" id="city" class="selectpicker" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @if($city->id == old('city')) selected @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-40" type="submit" form="register-form">Register <i class="icon-material-outline-arrow-right-alt"></i></button>
                    </form>
                    <div class="social-login-separator"><span>or</span></div>
                    <div class="social-login-buttons">
                        <a href="{{ route('social.redirect',['provider' => 'facebook']) }}" class="facebook-login ripple-effect"><i class="icon-brand-facebook-f"></i> Register via Facebook</a>
                        <a href="{{ route('social.redirect',['provider' => 'google']) }}" class="google-login ripple-effect"><i class="icon-brand-google-plus-g"></i> Register via Google+</a>
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
<script>
    $('.account-type label').click(function () {
        $(this).prev().prop('checked', true);
        // console.log($('input[name="on_budget"]:checked').val());
    });
</script>
</body>
</html>
