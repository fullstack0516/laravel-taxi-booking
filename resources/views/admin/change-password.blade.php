<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
                    <h3>Change Password</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Change Password</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <form action="{{ route('settings.change-password') }}" method="post" class="col-xl-12">
                        @csrf
                        {{--            <div class="col-xl-12">--}}
                        <div id="test1" class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
                            </div>
                            <div class="content with-padding">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>New Password</h5>
                                            <input type="password" class="with-border" name="password">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Repeat New Password</h5>
                                            <input type="password" class="with-border" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <button type="submit" class="button ripple-effect big margin-top-30">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--            </div>--}}
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
@if(session('success'))
    <script>
        $(document).ready(function() {
            Snackbar.show({
                text: '{{ session('success') }}',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#5f9025'
            });
        });
    </script>
@endif
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
