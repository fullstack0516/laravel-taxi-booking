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
    <div class="single-page-header" data-background-image="{{ asset('images/single-job.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image"><a href="#"><img src="@if($ride->owner->profile->avatar) {{ $ride->owner->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif" alt=""></a></div>
                            <div class="header-details">
                                {{--                                <h3>{{ $ride->title }}</h3>--}}
                                <h5>About the Customer</h5>
                                <ul>
                                    <li><a href="#"><i class="icon-material-outline-business"></i> {{ $ride->owner->name }}</a></li>
                                    {{--                                    <li><div class="star-rating" data-rating="4.9"></div></li>--}}
                                    {{--                                    <li><img class="flag" src="images/flags/gb.svg" alt=""> United Kingdom</li>--}}
                                </ul>
                                <ul>
                                    @if($ride->owner->hasVerifiedEmail())<li><div class="verified-badge-with-title"> Email Verified </div></li>@endif
                                    @if($ride->owner->hasVerifiedPhone())<li><div class="verified-badge-with-title"> Phone Verified </div></li>@endif
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <div class="salary-type">Price</div>
{{--                                <div class="salary-amount">${{ $ride->price_min }} - ${{ $ride->price_max }}</div>--}}
                                <div class="salary-amount">${{ $ride->price_min }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 content-right-offset">
                @if($ride->description)
                <div class="single-page-section">
                    <h3 class="margin-bottom-25">Description</h3>
                    <p style="word-break: break-all">{!! $ride->description !!}</p>
                </div>
                @endif
                <div class="single-page-section">
                    <h3 class="margin-bottom-30">Location</h3>
                    <div id="single-job-map-container">
                        <div id="singleListingMap" data-map-icon="im im-icon-Hamburger"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">
                    <a href="javascript:;" class="apply-now-button popup-with-zoom-anim"
                       onclick="window.location.href='{{ route('login') }}'"
                    >
                        Login To Apply <i class="icon-material-outline-arrow-right-alt"></i>
                    </a>
                    <div class="sidebar-widget">
                        <div class="job-overview">
                            <div class="job-overview-headline">Summary</div>
                            <div class="job-overview-inner">
                                <ul>
                                    <li>
                                        <i class="icon-material-outline-location-on"></i>
                                        <span>Location</span>
                                        <h5><strong>From:</strong> {{ $ride->address_from }}</h5>
                                        <h5><strong>To:</strong> {{ $ride->address_to }}</h5>
                                        <input type="text" value="{{ $ride->address_from }}" id="address_from" hidden>
                                        <input type="text" value="{{ $ride->address_to }}" id="address_to" hidden>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-access-time"></i>
                                        <span>Time</span>
                                        <h5><strong>From:</strong> {{ $ride->time_from->format('M d,Y g:i') }}</h5>
                                        {{--                                        <h5><strong>To:</strong> {{ $ride->time_to->format('M d,Y g:i') }}</h5>--}}
                                    </li>
                                    <li>
                                        <i class="icon-line-awesome-group"></i>
                                        <span>Seats</span>
                                        {{--                                        <h5>${{ $ride->price_min }} - ${{ $ride->price_max }}</h5>--}}
                                        <h5>{{ $ride->seats }}</h5>
                                    </li>
                                    <li>
                                        <i class="icon-line-awesome-group"></i>
                                        <span>Type</span>
                                        {{--                                        <h5>${{ $ride->price_min }} - ${{ $ride->price_max }}</h5>--}}
                                        <h5>{{ $ride->type->title }}</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-local-atm"></i>
                                        <span>Price</span>
{{--                                        <h5>${{ $ride->price_min }} - ${{ $ride->price_max }}</h5>--}}
                                        <h5>${{ $ride->price_min }}</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-access-time"></i>
                                        <span>Date Posted</span>
                                        <h5>{{ $ride->updated_at->diffForHumans() }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{--                    <div class="sidebar-widget">--}}
                    {{--                        <h3>Bookmark or Share</h3>--}}
                    {{--                        <button class="bookmark-button margin-bottom-25">--}}
                    {{--                            <span class="bookmark-icon"></span>--}}
                    {{--                            <span class="bookmark-text">Bookmark</span>--}}
                    {{--                            <span class="bookmarked-text">Bookmarked</span>--}}
                    {{--                        </button>--}}
                    {{--                        <div class="copy-url">--}}
                    {{--                            <input id="copy-url" type="text" value="" class="with-border">--}}
                    {{--                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="share-buttons margin-top-25">--}}
                    {{--                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>--}}
                    {{--                            <div class="share-buttons-content">--}}
                    {{--                                <span>Interesting? <strong>Share It!</strong></span>--}}
                    {{--                                <ul class="share-buttons-icons">--}}
                    {{--                                    <li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>--}}
                    {{--                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>--}}
                    {{--                                    <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>--}}
                    {{--                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>--}}
                    {{--                                </ul>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                </div>
            </div>
        </div>
    </div>
    <!-- Content / End -->

    @include('partials.footer')
</div>


<!-- Scripts
================================================== -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.4.1/js/bootstrap.bundle.js') }}"></script>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
<script>
    function initRide() {
        let map = new google.maps.Map(document.getElementById('singleListingMap'));
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
    }
    $(document).ready(function () {
        initRide();
    });
</script>
</body>
</html>
