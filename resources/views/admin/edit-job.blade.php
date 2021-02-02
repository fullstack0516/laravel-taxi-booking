<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/kendo-ui/kendo.common.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/kendo-ui/kendo.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/kendo-ui/kendo.default.mobile.min.css') }}">
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
                    <h3>Edit Ride</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Edit Ride</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <form action="{{ route('rides.update', ['ride' => $ride->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-feather-folder-plus"></i> Ride Submission Form</h3>
                                </div>
                                <div class="content with-padding padding-bottom-10">
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            <div class="notification error closeable">
                                                <p>{{ $error }}</p>
                                                <a class="close">
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="row">

                                        {{--                            <div class="col-xl-4">--}}
                                        {{--                                <div class="submit-field">--}}
                                        {{--                                    <h5>Title</h5>--}}
                                        {{--                                    <input type="text" class="with-border" name="title" value="{{ old('title', $ride->title) }}" required autofocus>--}}
                                        {{--                                </div>--}}
                                        {{--                            </div>--}}
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Type</h5>
                                                <select class="selectpicker" name="ride_type">
                                                    <option value="">Select Type</option>
                                                    @foreach($types as $type)
                                                        <option value="{{ $type->id }}" @if($ride->type->id == $type->id) selected @endif>{{ $type->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Seats</h5>
                                                <input type="number" class="with-border" name="seats" value="{{ old('seats', $ride->seats) }}" required autofocus>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Location From</h5>
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                        <input id="address_from" class="with-border" type="text" name="address_from" value="{{ old('address_from', $ride->address_from) }}" placeholder="Type Address" required>
                                                    </div>
                                                    <i class="icon-material-outline-location-on"></i>
                                                </div>
                                            </div>
                                            <input name="location_from_lat" id="location_from_lat" type="hidden" value="{{ old('location_from_lat', $ride->location_from->getLat()) }}" readonly>
                                            <input name="location_from_lng" id="location_from_lng" type="hidden" value="{{ old('location_from_lng', $ride->location_from->getLng()) }}" readonly>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Location To</h5>
                                                <div class="input-with-icon">
                                                    <div id="autocomplete-container">
                                                        <input id="address_to" class="with-border" type="text" name="address_to" value="{{ old('address_to', $ride->address_to) }}" placeholder="Type Address" required>
                                                    </div>
                                                    <i class="icon-material-outline-location-on"></i>
                                                </div>
                                            </div>
                                            <input id="location_to_lat" name="location_to_lat" type="hidden" value="{{ old('location_to_lat', $ride->location_to->getLat()) }}" readonly >
                                            <input id="location_to_lng" name="location_to_lng" type="hidden" value="{{ old('location_to_lng', $ride->location_to->getLng()) }}" readonly>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>Date and Time</h5>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <input class="with-border" type="text" placeholder="" id="time_from" name="time_from" value="{{ old('time_from', $ride->time_from->format('M j, Y, G:i')) }}" style="width: 100%;">
                                                    </div>
                                                    {{--                                        <div class="col-xl-6">--}}
                                                    {{--                                            <input class="with-border" type="text" placeholder="From When" id="time_from" name="time_from" value="{{ old('time_from') }}">--}}
                                                    {{--                                        </div>--}}
                                                    {{--                                        <div class="col-xl-6">--}}
                                                    {{--                                            <input class="with-border" type="text" placeholder="To When" id="time_to" name="time_to" value="{{ old('time_to') }}">--}}
                                                    {{--                                        </div>--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Price</h5>
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="input-with-icon">
                                                            <input class="with-border" type="text" placeholder="Min" name="salary_min" value="{{ old('price_min', $ride->price_min) }}">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="input-with-icon">
                                                            <input class="with-border" type="text" placeholder="Max" name="salary_max" value="{{ old('price_max', $ride->price_max) }}">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div id="map-container">

                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Description</h5>
                                                <textarea cols="30" rows="5" class="with-border" name="description">{{ old('description', $ride->description) }}</textarea>
                                                {{--                                    <div class="uploadButton margin-top-30">--}}
                                                {{--                                        <input class="uploadButton-input" type="text" name="file_path" id="file_path" hidden />--}}
                                                {{--                                        <label id="uploadFile" data-input="file_path" class="uploadButton-button ripple-effect" for="upload">Upload Files</label>--}}
                                                {{--                                        <span class="uploadButton-file-name">Images or documents that might be helpful in describing your job</span>--}}
                                                {{--                                    </div>--}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <button class="button ripple-effect big margin-top-30" id="post_job" type="submit"><i class="icon-feather-plus"></i> Post a Ride</button>
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
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@else
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
@endif
<script src="{{ asset('vendor/kendo-ui/kendo.ui.core.min.js') }}"></script>
<script src="{{ asset('vendor/kendo-ui/kendo.datetimepicker.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#time_from").kendoDateTimePicker({
            value: new Date($("#time_from").val()),
            dateInput: true
        });
        initMap();
    });

    function initMap() {
        let map = new google.maps.Map(document.getElementById('map-container'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
        });
        let addressFromInput = document.getElementById('address_from');
        let addressToInput = document.getElementById('address_to');
        let locationFromLat = document.getElementById('location_from_lat');
        let locationFromLng = document.getElementById('location_from_lng');
        let locationToLat = document.getElementById('location_to_lat');
        let locationToLng = document.getElementById('location_to_lng');

        let autocompleteFrom = new google.maps.places.Autocomplete(addressFromInput);
        let autocompleteTo = new google.maps.places.Autocomplete(addressToInput);

        let geocoder = new google.maps.Geocoder;
        let directionsService = new google.maps.DirectionsService();
        let directionsRenderer = new google.maps.DirectionsRenderer();

        let infowindowFrom = new google.maps.InfoWindow();
        let infowindowTo = new google.maps.InfoWindow();

        let LatLngFrom = new google.maps.LatLng({lat: -33.8688, lng: 151.2195});
        let LatLngTo = new google.maps.LatLng({lat: -33.8688, lng: 151.2195});

        directionsRenderer.setMap(map);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocompleteFrom.bindTo('bounds', map);
        autocompleteTo.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocompleteFrom.setFields(
            ['address_components', 'geometry', 'icon', 'name']);
        autocompleteTo.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        if(addressToInput.value !== '' && addressFromInput.value !== '') {
            onChangeHandler();
        }

        autocompleteFrom.addListener('place_changed', function() {
            infowindowFrom.close();
            var place = autocompleteFrom.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                // map.setCenter(place.geometry.location);
                // map.setZoom(17);  // Why 17? Because it looks good.
            }

            LatLngFrom = place.geometry.location;

            locationFromLat.value = place.geometry.location.lat();
            locationFromLng.value = place.geometry.location.lng();

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            onChangeHandler();
        });
        autocompleteTo.addListener('place_changed', function() {
            infowindowTo.close();
            let place = autocompleteTo.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            LatLngTo = place.geometry.location;
            locationToLat.value = place.geometry.location.lat();
            locationToLng.value = place.geometry.location.lng();

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            onChangeHandler();
        });

        function handleLocationError(browserHasGeolocation, pos) {
            if (browserHasGeolocation) {
                window.alert('Error: The Geolocation service failed.');
            } else {
                window.alert('Error: Your browser doesn\'t support geolocation.');
            }
        }

        function onChangeHandler () {
            calculateAndDisplayRoute(directionsService, directionsRenderer);
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer) {
            if(addressToInput.value !== '' && addressFromInput.value !== '') {
                directionsService.route(
                    {
                        origin: {query: document.getElementById('address_from').value},
                        destination: {query: document.getElementById('address_to').value},
                        travelMode: 'DRIVING'
                    },
                    function(response, status) {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(response);
                        } else {
                            // window.alert('Directions request failed due to ' + status);
                        }
                    });
            }
        }
    }
</script>
</body>
</html>
