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
                    <h3>Manage Rides</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Manage Rides</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">
                            <div class="headline">
                                <h3><i class="icon-material-outline-business-center"></i> My Ride Listings</h3>
                            </div>

                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($rides as $ride)
                                        <li>
                                            <div class="job-listing">
                                                <div class="col-md-2 align-self-center">
                                                    <img style="border-radius: 10px;" src="@if($ride->owner->profile->avatar) {{ $ride->owner->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif">
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="job-listing-details">
                                                        <div class="job-listing-description">
                                                            <h3 class="job-listing-title">
                                                                <a href="{{ route('users.edit', ['user' => $ride->owner->id]) }}">{{ $ride->owner->first_name.' '.$ride->owner->last_name }}</a>
                                                            </h3>
                                                            <div class="job-listing-footer">
                                                                <ul>
                                                                    <li><i class="icon-material-outline-date-range"></i> Posted on {{ $ride->updated_at->format('M d, Y') }}</li>
                                                                    {{--                                                <li><i class="icon-material-outline-date-range"></i> Expiring on 10 August, 2019</li>--}}
                                                                </ul>
                                                                <ul class="margin-top-12">
                                                                    <li>
                                                                        <i class="icon-line-awesome-tag"></i> Type
                                                                        <span class="dashboard-status-button yellow">{{ $ride->type->title }}</span></li>
                                                                    <li>
                                                                        <i class="icon-line-awesome-users"></i> Seats
                                                                        <span class="dashboard-status-button yellow">{{ $ride->seats }}</span>
                                                                    </li>
                                                                </ul>
                                                                <ul class="margin-top-12">
                                                                    <li>
                                                                        <i class="icon-material-outline-location-on"></i> From
                                                                        <span class="dashboard-status-button green">{{ $ride->address_from }}</span></li>
                                                                    <li>
                                                                        <i class="icon-material-outline-location-off"></i> To
                                                                        <span class="dashboard-status-button green">{{ $ride->address_to }}</span>
                                                                    </li>
                                                                </ul>
                                                                <ul class="margin-top-12">
                                                                    <li>
                                                                        <i class="icon-material-outline-watch"></i> Time
                                                                        <span class="dashboard-status-button red">{{ $ride->time_from->format('M d, Y H:i A') }}</span>
                                                                    </li>
                                                                    {{--                                                <li>--}}
                                                                    {{--                                                    <i class="icon-material-outline-watch"></i> To--}}
                                                                    {{--                                                    <span class="dashboard-status-button red">{{ $ride->time_to->format('M d, Y H:i A') }}</span>--}}
                                                                    {{--                                                </li>--}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="dashboard-task-info">
                                                @if($ride->completed_at)
                                                    <li><strong>{{ $ride->driver->first_name.' '.$ride->driver->last_name }}</strong><span>Driver</span></li>
                                                    <li><strong>${{ $ride->accepted_salary }}</strong><span>Paid Amount</span></li>
                                                @else
                                                    <li><strong>{{ $ride->bids()->count() }}</strong><span>Bids</span></li>
                                                    <li><strong>${{ $ride->bids()->average('price') }}</strong><span>Avg. Bid</span></li>
                                                @endif
                                            </ul>
                                            <div class="buttons-to-right always-visible">
                                                <a href="{{ route('rides.show', ['ride' => $ride->id]) }}" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Show Drivers <span class="button-info">{{ $ride->bids()->count() }}</span></a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="with-padding">
                                    {{ $rides->links() }}
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
<script>
    $('.button.remove').click(function () {
        $(this).next().submit();
    })
</script>
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
@endif
</body>
</html>
