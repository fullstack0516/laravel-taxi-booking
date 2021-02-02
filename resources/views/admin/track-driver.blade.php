<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
    <style>
        html, body {
            height: 100%;
        }
        #map {
            height: 100vh;
        }
    </style>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    <header id="header-container" class="fullwidth">
        <!-- Header -->
        <div id="header">
            <div class="container">
                <!-- Left Side Content -->
                <div class="left-side">

                    <!-- Logo -->
                    <div id="logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                    </div>

                    <!-- Main Navigation -->
                    <nav id="navigation">
                        <ul id="responsive">
                            <li>
                                <a href="{{ url('/') }}" class="current">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('rides.show', ['ride' => $ride]) }}">Show Ride</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="clearfix"></div>
                    <!-- Main Navigation / End -->

                </div>
                <!-- Left Side Content / End -->


                <!-- Right Side Content / End -->
                <div class="right-side">

                    <!--  User Notifications -->
                        <div class="header-widget hide-on-mobile">

                            <!-- Notifications -->
                            <div class="header-notifications">
                                <div class="header-notifications-trigger">
                                    <a href="#"><i class="icon-feather-bell"></i>@if(auth()->user()->unreadNotifications->count() > 0) <span> {{ auth()->user()->unreadNotifications->count() }} </span> @endif</a>
                                </div>
                                <div class="header-notifications-dropdown">
                                    <div class="header-notifications-headline">
                                        <h4>Notifications</h4>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left" form="mark-as-read">
                                                <i class="icon-feather-check-square"></i>
                                            </button>
                                            <form id="mark-as-read" action="{{ route('notifications.update-all') }}" method="post">
                                                @csrf
                                                @method('put')
                                            </form>
                                        @endif
                                    </div>

                                    <div class="header-notifications-content">
                                        <div class="header-notifications-scroll" data-simplebar>
                                            <ul>
                                                <!-- Notification -->
                                                @if(auth()->user()->unreadNotifications->count() > 0)
                                                    @foreach(auth()->user()->unreadNotifications as $notification)
                                                        <li class="notifications-not-read">
                                                            <a href="#">
                                                                <span class="notification-icon"><i class="icon-material-outline-group"></i></span>
                                                                <span class="notification-text">
                                                            {{ $notification->data['title'] }}
                                                        </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="notifications-not-read">
                                                        <a href="#" style="justify-content: center;">
                                                        <span>
                                                            <strong>No Notifications</strong>
                                                        </span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                <!--  User Notifications / End -->
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
                <!-- Mobile Navigation Button -->
                    <span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

                </div>
                <!-- Right Side Content / End -->

            </div>
        </div>
        <!-- Header / End -->

    </header>
    <div class="clearfix"></div>
    <div>
        <input type="text" value="{{ $ride->address_from }}" id="address_from" hidden>
        <input type="text" value="{{ $ride->address_to }}" id="address_to" hidden>
    </div>


<!-- Content / Start -->
    <div id="map">
    </div>
    <!-- Content / End -->
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
<script type="text/javascript">
    $(document).ready(function () {
        let map = new google.maps.Map(document.getElementById('map'));
        let addressFromInput = document.getElementById('address_from');
        let addressToInput = document.getElementById('address_to');

        let directionsService = new google.maps.DirectionsService();
        let directionsRenderer = new google.maps.DirectionsRenderer();

        directionsRenderer.setMap(map);

        function onChangeHandler() {
            calculateAndDisplayRoute(directionsService, directionsRenderer);
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer) {
            directionsService.route(
                {
                    origin: {query: addressFromInput.value},
                    destination: {query: addressToInput.value},
                    travelMode: 'DRIVING'
                },
                function(response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
        }

        onChangeHandler();

        setInterval(function () {
            var geocoder = new google.maps.Geocoder();

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    let LatLng = new google.maps.LatLng(pos);
                    var marker = new google.maps.Marker({
                        position: LatLng,
                        map: map,
                        icon: '{{ asset('images/marker-car.png') }}',
                        title: 'Driver',
                    });

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
                                        // TODO
                                    },
                                    error: function (xhr, error) {
                                        console.log(error);
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
        }, 5000);
    })
</script>
</body>
</html>
