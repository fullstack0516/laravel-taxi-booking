<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
</head>
<body class="gray">
<div id="wrapper">
    @include('partials.admin-header')
    <div class="clearfix"></div>
    <div class="dashboard-container">
        @include('partials.admin-sidebar')
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">
                <!-- start content -->
                <div class="dashboard-headline">
                    <h3>Settings</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Settings</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    @if($errors->any())
                        <div class="col-xl-12">
                            @foreach($errors->all() as $error)
                                <div class="notification error closeable">
                                    <p>{{ $error }}</p>
                                    <a class="close">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('settings.store-role') }}" method="post" class="col-xl-12">
                        @csrf
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-line-awesome-group"></i> Account Type</h3>
                            </div>
                            <div class="content with-padding">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="submit-field">
                                            <div class="account-type">
                                                <div>
                                                    <input type="radio" name="role" id="employer-radio"
                                                           class="account-type-radio" value="customer" @if(auth()->user()->hasRole('customer')) checked @endif/>
                                                    <label for="employer-radio" class="ripple-effect-dark">
                                                        <i class="icon-material-outline-business-center"></i> Customer</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="role" id="freelancer-radio" class="account-type-radio" value="driver" @if(auth()->user()->hasRole('driver')) checked @endif/>
                                                    <label for="freelancer-radio" class="ripple-effect-dark">
                                                        <i class="icon-material-outline-account-circle"></i>
                                                        Driver</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-field">
                                    <button class="button">Next</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end content -->
                <div class="dashboard-footer-spacer"></div>
                @include('partials.admin-footer')
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
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
@include('scripts.pusher-notification')
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
@if(auth()->check() && auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
