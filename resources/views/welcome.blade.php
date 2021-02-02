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



    <!-- Intro Banner
    ================================================== -->
    <!-- add class "disable-gradient" to enable consistent background overlay -->
    <div class="intro-banner" data-background-image="images/home-background.jpg">
        <div class="container">

            <!-- Intro Headline -->
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-headline">
                        <h2 style="color: #2a41e8; font-weight: bold">Ride for Everyone</h2>
                        <br>
                        <h3>
                            <strong>Youwala is a ride share platform where riders</strong>
                            <br />
                            <strong>and drivers bid on prices</strong>
                            <br />
                            <strong>Bidding gives the fairest deals without the site</strong>
                            <br />
                            <strong>deciding for you</strong>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            @if(auth()->check() && auth()->user()->hasRole('driver'))
            @else
            <div class="row">
                <div class="col-md-12">
                    <form class="intro-banner-search-form margin-top-95" action="{{ route('post-ride') }}" method="post">
                        @csrf
                        <div class="intro-search-field with-autocomplete">
                            <label for="autocomplete-input" class="field-title ripple-effect">From</label>
                            <div class="input-with-icon">
                                <input id="address_from" name="address_from" type="text" placeholder="From" required>
                                <i class="icon-material-outline-location-on"></i>
                            </div>
                        </div>
                        <div class="intro-search-field with-autocomplete">
                            <label for="autocomplete-input" class="field-title ripple-effect">To</label>
                            <div class="input-with-icon">
                                <input id="address_to" name="address_to" type="text" placeholder="To" required>
                                <i class="icon-material-outline-location-on"></i>
                            </div>
                        </div>
                        <div class="intro-search-button">
                            <button class="button ripple-effect" type="submit">Post a Ride</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

{{--            <!-- Stats -->--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <ul class="intro-stats margin-top-45 hide-under-992px">--}}
{{--                        <li>--}}
{{--                            <strong class="counter">1,586</strong>--}}
{{--                            <span>Jobs Posted</span>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <strong class="counter">3,543</strong>--}}
{{--                            <span>Tasks Posted</span>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <strong class="counter">1,232</strong>--}}
{{--                            <span>Freelancers</span>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
    </div>

    <!-- Features Cities -->
    <div class="section margin-top-65 margin-bottom-65">
        <div class="container">
            <div class="row">

                <!-- Section Headline -->
                <div class="col-xl-12">
                    <div class="section-headline centered margin-top-0 margin-bottom-45">
                        <h3>Featured Cities</h3>
                    </div>
                </div>

                @foreach($cities as $city)
                <div class="col-xl-3 col-md-6">
                    <!-- Photo Box -->
                    <a href="javascript:;" class="photo-box" data-background-image="{{ $city->background_image }}">
                        <div class="photo-box-content">
                            <h3>{{ $city->name }}</h3>
                            <span>{{ $city->rides->count() }} Rides</span>
                        </div>
                        <form action="{{ route('rides.index') }}">
                            <input type="hidden" name="latitude" value="{{ $city->location->getLat() }}">
                            <input type="hidden" name="longitude" value="{{ $city->location->getLng() }}">
                        </form>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Features Cities / End -->

    @include('partials.footer')

</div>
<!-- Wrapper / End -->


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
<script>
    $('.photo-box').click(function() {
        $(this).find('form').submit();
    });
</script>
@if(auth()->check() && auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@else
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
@endif
<script>
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    function initMap() {
        let addressFromInput = document.getElementById('address_from');
        let addressToInput = document.getElementById('address_to');

        let autocompleteFrom = new google.maps.places.Autocomplete(addressFromInput);
        let autocompleteTo = new google.maps.places.Autocomplete(addressToInput);
        var geocoder = new google.maps.Geocoder();

        autocompleteFrom.setFields(
            ['address_components', 'geometry', 'icon', 'name']);
        autocompleteTo.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                let LatLngFrom = new google.maps.LatLng(pos);
                // let LatLngTo = new google.maps.LatLng(pos);

                geocoder.geocode({'location': LatLngFrom}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            addressFromInput.value = results[0].formatted_address;
                            // addressToInput.value = results[0].formatted_address;

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
    }

    initMap();
</script>
</body>
</html>
