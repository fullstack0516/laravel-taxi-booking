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
                    <h3>All Cities</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>All Cities</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-line-awesome-building"></i> New City</h3>
                            </div>
                            <div class="content" style="padding: 20px 30px">
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="notification error closeable">
                                            <p>{{ $error }}</p>
                                            <a class="close">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <form class="row" action="{{ route('cities.store') }}" method="post" id="city-form">
                                    @csrf
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>City Name</h5>
                                            <input type="text" class="with-border" name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                        <div class="submit-field">
                                            <h5>Address</h5>
                                            <input type="text" id="address" class="with-border" name="address" value="{{ old('address') }}" required>
                                        </div>
                                        <div class="submit-field">
                                            <h5>Country</h5>
                                            <select class="selectpicker" id="country_code" name="country_code" required>
                                                <option value="us">United States</option>
                                                <option value="in">India</option>
                                                <option value="hk">Hong Kong</option>
                                            </select>
{{--                                            <input type="text" id="country_code" class="with-border" name="country_code" value="{{ old('country_code') }}" required>--}}
                                        </div>
                                        <div class="submit-field">
                                            <h5>Background Image</h5>
                                            <div class="keyword-input-container">
                                                <input type="text" class="keyword-input" id="background_image" name="background_image" value="{{ old('background_image') }}" placeholder="Background Image" required>
                                                <button class="keyword-input-button ripple-effect" id="lfm" data-input="background_image" type="button"><i class="icon-line-awesome-picture-o"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="longitude" id="longitude">
                                        <input type="hidden" name="postal_code" id="postal_code">
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="map" id="map" style="min-height: 300px; height: 100%; border: solid 1px red;">

                                        </div>
                                    </div>
                                </form>
                                <div class="submit-field">
                                    <button class="button ripple-effect big margin-top-30" form="city-form" type="submit"><i class="icon-feather-plus"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@else
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
@endif
<script type="text/javascript">
    $(document).ready(function() {
        let map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 37.7749, lng: -122.4194},
            zoom: 13
        });
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: ['us', 'in', 'hk']}
        };
        let addressInput = document.getElementById('address');
        let latitude = document.getElementById('latitude');
        let longitude = document.getElementById('longitude');
        let postal_code = document.getElementById('postal_code');

        let autocomplete = new google.maps.places.Autocomplete(addressInput, options);

        let marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            let place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            let location = place.geometry.location;
            latitude.value = location.lat();
            longitude.value = location.lng();

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            if (place.postcode_localities) {
                postal_code.value = place.postcode_localities[0];
            }
        });
    });
</script>
</body>
</html>
