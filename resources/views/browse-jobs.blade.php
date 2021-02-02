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
    <div class="full-page-container with-map">
        <div class="full-page-sidebar hidden-sidebar">
            <div class="full-page-sidebar-inner" data-simplebar>

                <div class="sidebar-container">

                    <!-- Location -->
                    <div class="sidebar-widget">
                        <h3>Location</h3>
                        <div class="input-with-icon">
                            <div id="autocomplete-container">
                                <input id="autocomplete-input" type="text" name="location" placeholder="Location">
                            </div>
                            <i class="icon-material-outline-location-on"></i>
                        </div>
                    </div>

                    <!-- Keywords -->
                    <div class="sidebar-widget">
                        <h3>Keywords</h3>
                        <div class="keywords-container">
                            <div class="keyword-input-container">
                                <input type="text" class="keyword-input" placeholder="e.g. job title"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Container / End -->

                <!-- Search Button -->
                <div class="sidebar-search-button-container">
                    <button class="button ripple-effect">Search</button>
                </div>
                <!-- Search Button / End-->

            </div>
        </div>
        <div class="full-page-content-container" data-simplebar>
            <div class="full-page-content-inner">

                <h3 class="page-title">Search Results</h3>

{{--                <div class="notify-box margin-top-15">--}}
{{--                    <div class="switch-container">--}}
{{--                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span class="switch-text">Turn on email alerts for this search</span></label>--}}
{{--                    </div>--}}
{{--                    <div class="sort-by">--}}
{{--                        <span>Sort by:</span>--}}
{{--                        <select class="selectpicker hide-tick">--}}
{{--                            <option>Relevance</option>--}}
{{--                            <option>Newest</option>--}}
{{--                            <option>Oldest</option>--}}
{{--                            <option>Random</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="listings-container compact-list-layout margin-top-35 margin-bottom-25">
                    @foreach($rides as $ride)
                        @if(auth()->check() && $ride->accepted_at)
{{--                            @if(auth()->check() && $ride->driver_id == auth()->user()->id)--}}
                            <a href="{{ route('rides.show', ['ride' => $ride]) }}" class="job-listing">
                                <div class="job-listing-details">
                                    <div class="job-listing-company-logo">
                                        <img src="@if($ride->owner->profile->avatar){{ $ride->owner->profile->avatar }}@else{{ asset('images/user-avatar-placeholder.png') }} @endif" alt="">
                                    </div>
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            #{{ $ride->id }} <span class="badge badge-success">Applied Driver(s): {{ $ride->bids()->count() }}</span> @if($ride->driver_id && $ride->driver_id == auth()->user()->id) <span class="badge badge-danger">You Accepted</span> @elseif($ride->driver_id && $ride->driver_id != auth()->user()->id) <span class="badge badge-warning">Others Accepted</span> @endif
                                        </h3>
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-business"></i> {{ $ride->owner->name }}
                                                    @if($ride->owner->hasVerifiedEmail())<div class="verified-badge" title="Email Verified Employer" data-tippy-placement="top" style="background-color: #28a745"></div>@endif
                                                    @if($ride->owner->hasVerifiedPhone())<div class="verified-badge" title="Phone Verified Employer" data-tippy-placement="top" style="background-color: #17a2b8"></div>@endif
                                                </li>
                                                <li><i class="icon-material-outline-access-time"></i> {{ $ride->updated_at->diffForHumans() }}</li>
                                                <li><strong>From</strong> <i class="icon-material-outline-location-on"></i> {{ $ride->address_from }}</li>
                                                <li><strong>To</strong> <i class="icon-material-outline-location-off"></i> {{ $ride->address_to }}</li>
                                                <li><strong>Time</strong> <i class="icon-material-outline-access-time"></i> {{ $ride->time_from->format('M j, Y, G:i') }}</li>
                                                {{--                                        <li><strong>To</strong> <i class="icon-material-outline-access-time"></i> {{ $ride->time_to->format('M j, Y, G:i') }}</li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                    <span class="bookmark-icon"></span>
                                </div>
                            </a>
{{--                            @else--}}
{{--                            @endif--}}
                        @else
                            <a href="{{ route('rides.show', ['ride' => $ride]) }}" class="job-listing">
                                <div class="job-listing-details">
                                    <div class="job-listing-company-logo">
                                        <img src="@if($ride->owner->profile->avatar){{ $ride->owner->profile->avatar }}@else{{ asset('images/user-avatar-placeholder.png') }} @endif" alt="">
                                    </div>
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            #{{ $ride->id }} <span class="badge badge-success">Applied Driver(s): {{ $ride->bids()->count() }}</span> @if(auth()->user() && $ride->bids()->where('driver_id', auth()->user()->id)->first()) <span class="badge badge-secondary">You Applied</span> @endif
                                        </h3>
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-business"></i> {{ $ride->owner->name }}
                                                    @if($ride->owner->hasVerifiedEmail())<div class="verified-badge" title="Email Verified Employer" data-tippy-placement="top" style="background-color: #28a745"></div>@endif
                                                    @if($ride->owner->hasVerifiedPhone())<div class="verified-badge" title="Phone Verified Employer" data-tippy-placement="top" style="background-color: #17a2b8"></div>@endif
                                                </li>
                                                <li><i class="icon-material-outline-access-time"></i> {{ $ride->updated_at->diffForHumans() }}</li>
                                                <li><strong>From</strong> <i class="icon-material-outline-location-on"></i> {{ $ride->address_from }}</li>
                                                <li><strong>To</strong> <i class="icon-material-outline-location-off"></i> {{ $ride->address_to }}</li>
                                                <li><strong>Time</strong> <i class="icon-material-outline-access-time"></i> {{ $ride->time_from->format('M j, Y, G:i') }}</li>
                                                {{--                                        <li><strong>To</strong> <i class="icon-material-outline-access-time"></i> {{ $ride->time_to->format('M j, Y, G:i') }}</li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                    <span class="bookmark-icon"></span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class="pagination-container margin-top-20 margin-bottom-20">
                    {{ $rides->links() }}
                </div>
                <div class="clearfix"></div>
                <!-- Pagination / End -->

                <!-- Footer -->
                <div class="small-footer margin-top-15">
                    <div class="small-footer-copyrights">
                        © 2019 <strong>Youwala.com</strong>. All Rights Reserved.
                    </div>
                    <ul class="footer-social-links">
                        <li>
                            <a href="#" title="Facebook" data-tippy-placement="top">
                                <i class="icon-brand-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="LinkedIn" data-tippy-placement="top">
                                <i class="icon-brand-linkedin-in"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <!-- Footer / End -->

            </div>
        </div>
        <div class="full-page-map-container">

            <!-- Enable Filters Button -->
            <div class="filter-button-container">
                <button class="enable-filters-button">
                    <i class="enable-filters-button-icon"></i>
                    <span class="show-text">Show Filters</span>
                    <span class="hide-text">Hide Filters</span>
                </button>
                <div class="filter-button-tooltip">Click to expand sidebar with filters!</div>
            </div>

            <!-- Map -->
            <div id="map"></div>
        </div>
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
@if(auth()->check() && auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@else
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
@endif
<script>
    function initAutocomplete() {
        var input = document.getElementById('autocomplete-input');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
</script>
<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    $(document).ready(function () {
        // $.ajax({
        //     success: function(data) {
        //         initMap(data.rides.data);
        //     }
        // });
        let rides = @json($rides);
        initMap(rides.data);
    });
    function initMap(rides) {
        let map = new google.maps.Map(document.getElementById('map'));
        if (!rides.length) {
            return;
        }

        let directionsService = new google.maps.DirectionsService();
        // let directionsRenderer = new google.maps.DirectionsRenderer();

        // directionsRenderer.setMap(map);

        // function onChangeHandler() {
        //     calculateAndDisplayRoute(start, end);
        // }

        function calculateAndDisplayRoute(start, end) {
            directionsService.route(
                {
                    origin: {query: start},
                    destination: {query: end},
                    travelMode: 'DRIVING'
                },
                function(response, status) {
                    if (status === 'OK') {
                        let directionsRenderer = new google.maps.DirectionsRenderer();
                        directionsRenderer.setOptions({
                            polylineOptions: {
                                strokeColor: getRandomColor(),
                            }
                        });
                        directionsRenderer.setMap(map);
                        directionsRenderer.setDirections(response);
                    } else {
                        // window.alert('Directions request failed due to ' + status);
                    }
                });
        }

        rides.forEach(function (ride, i) {
            // console.log(v);
            setTimeout(calculateAndDisplayRoute(ride.address_from, ride.address_to), 100);
        });
        // onChangeHandler();
    }

</script>
</body>
</html>
