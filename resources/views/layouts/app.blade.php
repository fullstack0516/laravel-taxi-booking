<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
{{--    @yield('stylesheet')--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
{{--                            @if(auth()->guest() || auth()->user()->hasRole('driver'))--}}
{{--                                <li><a href="{{ route('jobs.index') }}">Find Job</a></li>--}}
{{--                            @endif--}}
{{--                            @if(auth()->guest() || auth()->user()->level() >= 2)--}}
{{--                                <li><a href="#">Find a Driver</a></li>--}}
{{--                                <li><a href="{{ route('jobs.create') }}">Post Job</a></li>--}}
{{--                            @endif--}}
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endguest
                        </ul>
                    </nav>
                    <div class="clearfix"></div>
                </div>
                <div class="right-side">
                    @if(auth()->check() && auth()->user()->hasVerifiedPhone())
{{--                        <div class="header-widget hide-on-mobile">--}}
{{--                            <div class="header-notifications">--}}
{{--                                <div class="header-notifications-trigger">--}}
{{--                                    <a href="#"><i class="icon-feather-bell"></i><span>4</span></a>--}}
{{--                                </div>--}}
{{--                                <div class="header-notifications-dropdown">--}}
{{--                                    <div class="header-notifications-headline">--}}
{{--                                        <h4>Notifications</h4>--}}
{{--                                        <button class="mark-as-read ripple-effect-dark" title="Mark all as read"--}}
{{--                                                data-tippy-placement="left">--}}
{{--                                            <i class="icon-feather-check-square"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}

{{--                                    <div class="header-notifications-content">--}}
{{--                                        <div class="header-notifications-scroll" data-simplebar>--}}
{{--                                            <ul>--}}
{{--                                                <li class="notifications-not-read">--}}
{{--                                                    <a href="dashboard-manage-candidates.html">--}}
{{--                                                        <span class="notification-icon">--}}
{{--                                                            <i class="icon-material-outline-group"></i>--}}
{{--                                                        </span>--}}
{{--                                                        <span class="notification-text">--}}
{{--                                                            <strong>Michael Shannah</strong> applied for a job--}}
{{--                                                            <span class="color">--}}
{{--                                                                Full Stack Software Engineer--}}
{{--                                                            </span>--}}
{{--												        </span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="dashboard-manage-bidders.html">--}}
{{--                                                        <span class="notification-icon">--}}
{{--                                                            <i class=" icon-material-outline-gavel"></i>--}}
{{--                                                        </span>--}}
{{--                                                        <span class="notification-text">--}}
{{--                                                            <strong>Gilbert Allanis</strong> placed a bid on your--}}
{{--                                                            <span class="color">iOS App Development</span> project--}}
{{--    												    </span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="dashboard-manage-jobs.html">--}}
{{--                                                        <span class="notification-icon">--}}
{{--                                                            <i class="icon-material-outline-autorenew"></i>--}}
{{--                                                        </span>--}}
{{--                                                        <span class="notification-text">--}}
{{--                                                            Your job listing--}}
{{--                                                            <span class="color">Full Stack PHP Developer</span> is expiring.--}}
{{--                                                        </span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="dashboard-manage-candidates.html">--}}
{{--                                                        <span class="notification-icon">--}}
{{--                                                            <i class="icon-material-outline-group"></i></span>--}}
{{--                                                        <span class="notification-text">--}}
{{--                                                            <strong>Sindy Forrest</strong>--}}
{{--                                                            applied for a job <span class="color">Full Stack Software Engineer</span>--}}
{{--                                                        </span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="header-notifications">--}}
{{--                                <div class="header-notifications-trigger">--}}
{{--                                    <a href="#"><i class="icon-feather-mail"></i><span>3</span></a>--}}
{{--                                </div>--}}
{{--                                <div class="header-notifications-dropdown">--}}
{{--                                    <div class="header-notifications-headline">--}}
{{--                                        <h4>Messages</h4>--}}
{{--                                        <button class="mark-as-read ripple-effect-dark" title="Mark all as read"--}}
{{--                                                data-tippy-placement="left">--}}
{{--                                            <i class="icon-feather-check-square"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                    <div class="header-notifications-content">--}}
{{--                                        <div class="header-notifications-scroll" data-simplebar>--}}
{{--                                            <ul>--}}
{{--                                                <li class="notifications-not-read">--}}
{{--                                                    <a href="dashboard-messages.html">--}}
{{--                                                    <span class="notification-avatar status-online">--}}
{{--                                                        <img src="{{ asset('images/user-avatar-small-03.jpg') }}" alt="">--}}
{{--                                                    </span>--}}
{{--                                                        <div class="notification-text">--}}
{{--                                                            <strong>David Peterson</strong>--}}
{{--                                                            <p class="notification-msg-text">Thanks for reaching out.--}}
{{--                                                                I'm quite busy right now on many...</p>--}}
{{--                                                            <span class="color">4 hours ago</span>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li class="notifications-not-read">--}}
{{--                                                    <a href="dashboard-messages.html">--}}
{{--                                                    <span class="notification-avatar status-offline">--}}
{{--                                                        <img src="{{ asset('images/user-avatar-small-02.jpg') }}" alt="">--}}
{{--                                                    </span>--}}
{{--                                                        <div class="notification-text">--}}
{{--                                                            <strong>Sindy Forest</strong>--}}
{{--                                                            <p class="notification-msg-text">Hi Tom! Hate to break it to--}}
{{--                                                                you, but I'm actually on vacation until...</p>--}}
{{--                                                            <span class="color">Yesterday</span>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li class="notifications-not-read">--}}
{{--                                                    <a href="dashboard-messages.html">--}}
{{--                                                    <span class="notification-avatar status-online">--}}
{{--                                                        <img src="{{ asset('images/user-avatar-placeholder.png') }}" alt="">--}}
{{--                                                    </span>--}}
{{--                                                        <div class="notification-text">--}}
{{--                                                            <strong>Marcin Kowalski</strong>--}}
{{--                                                            <p class="notification-msg-text">I received payment. Thanks--}}
{{--                                                                for--}}
{{--                                                                cooperation!</p>--}}
{{--                                                            <span class="color">Yesterday</span>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <a href="dashboard-messages.html"--}}
{{--                                       class="header-notifications-button ripple-effect button-sliding-icon">View All--}}
{{--                                        Messages<i class="icon-material-outline-arrow-right-alt"></i></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    @endif
                    @if(auth()->check())
                        <div class="header-widget">
                            <div class="header-notifications user-menu">
                                <div class="header-notifications-trigger">
                                    <a href="#">
                                        <div class="user-avatar status-online">
                                            <img
                                                src="@if(auth()->user()->profile && auth()->user()->profile->avatar) {{ auth()->user()->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif"
                                                alt="">
                                        </div>
                                    </a>
                                </div>
                                <div class="header-notifications-dropdown">
                                    <div class="user-status">
                                        <div class="user-details">
                                            <div class="user-avatar status-online">
                                                <img
                                                    src="@if(auth()->user()->profile && auth()->user()->profile->avatar) {{ auth()->user()->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif"
                                                    alt="">
                                            </div>
                                            <div class="user-name">
                                                {{ auth()->user()->name }} <span>@role('driver') Driver @endrole @role('customer') Customer @endrole</span>
                                            </div>
                                        </div>
                                        <div class="status-switch" id="snackbar-user-status">
                                            <label class="user-online current-status">Online</label>
                                            <label class="user-invisible">Invisible</label>
                                            <span class="status-indicator" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                    <ul class="user-menu-small-nav">
                                        <li>
                                            <a href="{{ route('dashboard') }}">
                                                <i class="icon-material-outline-dashboard"></i> Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('settings') }}">
                                                <i class="icon-material-outline-settings"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;"
                                               onclick="document.getElementById('logout-form').submit()">
                                                <i class="icon-material-outline-power-settings-new"></i> Logout
                                            </a>
                                        </li>
                                        <form style="display: none" action="{{ route('logout') }}" method="post"
                                              id="logout-form">
                                            @csrf
                                        </form>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    @endif
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
    @yield('content')
    @if(!request()->routeIs('rides.index'))
    <div id="footer">

        <!-- Footer Top Section -->
        <div class="footer-top-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">

                        <!-- Footer Rows Container -->
                        <div class="footer-rows-container">

                            <!-- Left Side -->
                            <div class="footer-rows-left">
                                <div class="footer-row">
                                    <div class="footer-row-inner footer-logo">
                                        <img src="{{ asset('images/logo2.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="footer-rows-right">
                                <div class="footer-row">
                                    <div class="footer-row-inner">
                                        <ul class="footer-social-links">
                                            <li>
                                                <a href="#" title="Facebook">
                                                    <i class="icon-brand-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" title="Google Plus">
                                                    <i class="icon-brand-google-plus-g"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" title="LinkedIn">
                                                    <i class="icon-brand-linkedin-in"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle-section">
            <div class="container">
                <div class="row">
                    @auth
                        <div class="col-xl-2 col-lg-2 col-md-3">
                        </div>
                    @endauth
                    @if(auth()->guest() || auth()->user()->hasRole('driver'))
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>For Drivers</h3>
                                <ul>
                                    <li><a href="{{ route('rides.index') }}"><span>Browse Rides</span></a></li>
{{--                                    <li><a href="#"><span>Job Alerts</span></a></li>--}}
{{--                                    <li><a href="#"><span>My Bookmarks</span></a></li>--}}
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if(auth()->guest() || auth()->user()->hasRole('customer'))
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>For Customers</h3>
                                <ul>
                                    <li><a href="#"><span>Browse Drivers</span></a></li>
                                    <li><a href="{{ route('rides.create') }}"><span>Post a Ride</span></a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <div class="footer-links">
                            <h3>Helpful Links</h3>
                            <ul>
                                <li><a href="#"><span>Contact</span></a></li>
                                <li><a href="#"><span>Privacy Policy</span></a></li>
                                <li><a href="#"><span>Terms of Use</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <div class="footer-links">
                            <h3>Account</h3>
                            <ul>
                                @guest
                                    <li><a href="{{ route('login') }}"><span>Log In</span></a></li>
                                @endguest
                                @auth
                                    <li><a href="{{ route('dashboard') }}"><span>My Account</span></a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                        <p>Weekly breaking news, analysis and cutting edge advices on job searching.</p>
                        <form action="#" method="get" class="newsletter">
                            <input type="text" name="fname" placeholder="Enter your email address">
                            <button type="button"><i class="icon-feather-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        © 2019 <strong>youwala.com</strong>. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @yield('modals')
</div>
<script src="{{ asset('js/app.js') }}"></script>
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
<script src="{{ asset('js/style.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
@if(auth()->check() && auth()->user()->hasRole('driver'))
    <script type="text/javascript">
        $(document).ready(function () {
            setInterval(function () {
                var geocoder = new google.maps.Geocoder();

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        let LatLng = new google.maps.LatLng(pos);

                        geocoder.geocode({'location': LatLng}, function(results, status) {
                            if (status === 'OK') {
                                if (results[0]) {
                                    $.ajax({
                                        url: '{{ route('locations.store') }}',
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            address: results[0].formatted_address,
                                            latitude: position.coords.latitude,
                                            longitude: position.coords.longitude,
                                        },
                                        success: function (data) {
                                            console.log(data.message);
                                        }
                                    });
                                } else {
                                    window.alert('No results found');
                                }
                            }
                        });

                    }, function() {
                        handleLocationError(true, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, map.getCenter());
                }

                function handleLocationError(browserHasGeolocation, pos) {
                    if (browserHasGeolocation) {
                        window.alert('Error: The Geolocation service failed.');
                    } else {
                        window.alert('Error: Your browser doesn\'t support geolocation.');
                    }
                }
            }, 10000);
        })
    </script>
@endif
{{--<script src="{{ asset('js/custom.js') }}"></script>--}}
@yield('custom_script')
</body>
</html>
