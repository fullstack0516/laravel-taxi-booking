<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

@include('partials.header')

<!-- Content / Start -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Confirm Password</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-register-page">
                    <div class="welcome-text">
                        <h3>We're glad to see you again!</h3>
                        <p>{{ __('Please confirm your password before continuing.') }}</p>
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
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                        @endif
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit">
                            {{ __('Confirm Password') }} <i class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="margin-top-70"></div>
    <!-- Content / End -->

    @include('partials.footer')
</div>


<!-- Scripts
================================================== -->
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
    // Snackbar for user status switcher
    $('#snackbar-user-status label').click(function() {
        Snackbar.show({
            text: 'Your status has been changed!',
            pos: 'bottom-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 3000,
            textColor: '#fff',
            backgroundColor: '#383838'
        });
    });
</script>
</body>
</html>
