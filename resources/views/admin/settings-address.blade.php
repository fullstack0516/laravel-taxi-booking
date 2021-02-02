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
                    <form action="{{ route('settings.store-address') }}" method="post" class="col-xl-12">
                        @csrf
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-outline-face"></i> My Address</h3>
                            </div>
                            <div class="content with-padding">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Address</h5>
                                            <div class="keyword-input-container">
                                                <input type="text" class="keyword-input" id="address" name="address" value="{{ old('address', $user->profile->address) }}" placeholder="Input Address" required>
                                                <button class="keyword-input-button ripple-effect" id="pickMe" type="button"><i class="icon-material-outline-my-location"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $user->profile->location->getLat()) }}" >
                                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $user->profile->location->getLng()) }}" >
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>City</h5>
                                            <select class="selectpicker" name="city" required>
                                                <option value="">Select City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if(($user_city && $city->id == $user_city->id) || ($city->id == old('city'))) selected @endif>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field d-flex">
                                            <a href="{{ route('settings.show-info') }}" class="button ripple-effect">
                                                <i class="icon-line-awesome-step-backward"></i> Previous
                                            </a>
                                            <button type="submit" class="button ripple-effect margin-left-20">
                                                Next <i class="icon-line-awesome-step-forward"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@else
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
@endif
<script>
    function initMap() {
        let addressInput = document.getElementById('address');
        let locationLat = document.getElementById('latitude');
        let locationLng = document.getElementById('longitude');

        let autocomplete = new google.maps.places.Autocomplete(addressInput);

        let geocoder = new google.maps.Geocoder;

        let LatLng = new google.maps.LatLng({lat: -33.8688, lng: 151.2195});

        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            LatLng = place.geometry.location;

            locationLat.value = place.geometry.location.lat();
            locationLng.value = place.geometry.location.lng();

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
        });

        $('#pickMe').click(function(e) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    LatLng = new google.maps.LatLng(pos);
                    locationLat.value = position.coords.latitude;
                    locationLng.value = position.coords.longitude;

                    geocoder.geocode({'location': LatLng}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                addressInput.value = results[0].formatted_address;
                            } else {
                                window.alert('No results found');
                            }
                        }
                    });
                }, function() {
                    handleLocationError(true);
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false);
            }
        });

        function handleLocationError(browserHasGeolocation) {
            if (browserHasGeolocation) {
                window.alert('Error: The Geolocation service failed.');
            } else {
                window.alert('Error: Your browser doesn\'t support geolocation.');
            }
        }
    }
    $(document).ready(function () {
        initMap();
    })
</script>
</body>
</html>
