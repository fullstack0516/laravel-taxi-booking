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
                    <h3>Manage Candidates</h3>
                    <span class="margin-top-7">Applications for <a href="{{ route('rides.edit', ['ride' => $ride->id]) }}">#{{ $ride->id }}</a></span>

                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Manage Candidates</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">
                            <div class="headline">
                                <h3><i class="icon-material-outline-supervisor-account"></i> {{ $ride->bids()->count() }} Candidates</h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($bids as $bid)
                                        <li>
                                            <div class="freelancer-overview manage-candidates">
                                                <div class="freelancer-overview-inner">
                                                    <div class="freelancer-avatar">
{{--                                                        <div class="verified-badge"></div>--}}
                                                        <a href="#"><img @if($bid->driver->profile->avatar) src="{{ $bid->driver->profile->avatar }}" @else src="{{ asset('images/user-avatar-placeholder.png') }}" @endif alt=""></a>
                                                    </div>
                                                    <div class="freelancer-name">
                                                        <h4><a href="#">{{ $bid->driver->name }} @if($bid->driver->stripeAccount) <span class="badge badge-primary">Payment Verified</span> @endif @if($bid->driver->phone_verified_at) <span class="badge badge-secondary">Phone Verified</span> @endif @if($bid->driver->email_verified_at) <span class="badge badge-warning">Email Verified</span> @endif</a></h4>
                                                        <span class="freelancer-detail-item"><i class="icon-feather-phone"></i> {{ $bid->driver->phone_number }}</span>
{{--                                                        <div class="freelancer-rating">--}}
{{--                                                            <div class="star-rating" data-rating="5.0"></div>--}}
{{--                                                        </div>--}}
                                                        <ul class="dashboard-task-info bid-info">
                                                            <li><strong>${{ $bid->price }}</strong><span>Price</span></li>
                                                        </ul>
                                                        <div class="buttons-to-right always-visible margin-top-25 margin-bottom-5">
                                                            @role('customer')
                                                            @if($bid->paid_at)
                                                                <a href="#small-dialog-4" class="popup-with-zoom-anim button ripple-effect leave-review" data-bid="{{ $bid->id }}"><i class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                                                            @else
                                                                @if($bid->accepted_at)
                                                                    <a href="#small-dialog-3" class="popup-with-zoom-anim button ripple-effect cancel red" data-bid="{{ $bid->id }}"><i class="icon-line-awesome-undo"></i> Cancel</a>
                                                                    <a href="{{ route('rides.track', ['ride' => $ride->id]) }}" class="button green ripple-effect"><i class="icon-line-awesome-car"></i> Track</a>
{{--                                                                    <a href="{{ route('bids.checkout-page', ['bid' => $bid->id]) }}" class="button ripple-effect"><i class="icon-line-awesome-dollar"></i> Checkout</a>--}}
                                                                @else
                                                                    <a href="#small-dialog-1" class="popup-with-zoom-anim button ripple-effect accept" data-bid="{{ $bid->id }}" data-price="{{ $bid->price }}" data-driver="{{ $bid->driver->first_name }}"><i class="icon-material-outline-check"></i> Accept</a>
                                                                @endif
                                                            @endif
                                                            <a href="#small-dialog-2" class="popup-with-zoom-anim button dark ripple-effect message" data-driver-name="{{ $bid->driver->first_name }}" data-driver-id="{{ $bid->driver->id }}"><i class="icon-feather-mail"></i> Send Message</a>
                                                            @endrole
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
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
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a href="#tab1">Accept Offer</a></li>
        </ul>
        <div class="popup-tabs-container">
            <div class="popup-tab-content" id="tab">
                <div class="welcome-text">
                    <h3 class="accept-title">Accept Offer From David</h3>
                    <div class="bid-acceptance margin-top-15">

                    </div>
                </div>
                <form id="terms" action="{{ route('bids.accept') }}" method="post">
                    @csrf
                    <input id="bid_id" name="bid_id" type="text" hidden>
                    <div class="radio">
                        <input name="radio" type="radio" required>
                        <label><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>
                    </div>
                </form>
                <button class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</div>
<div id="small-dialog-2" class="zoom-anim-dialog dialog-with-tabs mfp-hide">
    <div class="sign-in-form">
        <ul class="popup-tabs-nav" style="pointer-events: none;">
            <li class="active"><a href="#tab2">Send Message</a></li>
        </ul>
        <div class="popup-tabs-container">
            <div class="popup-tab-content" id="tab2" style="">
                <div class="welcome-text">
                    <h3 class="message-title">Direct Message To David</h3>
                </div>
                <form id="send-pm" action="{{ route('chat.send-message') }}">
                    @csrf
                    <input name="driver_id" type="hidden" id="driver_id">
                    <textarea name="message" cols="10" placeholder="Message" class="with-border" required=""></textarea>
                </form>
                <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="send-pm">Send <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</div>
<div id="small-dialog-3" class="zoom-anim-dialog dialog-with-tabs mfp-hide">
    <div class="sign-in-form">
        <ul class="popup-tabs-nav" style="pointer-events: none;">
            <li class="active"><a href="#tab3">Cancel Accept</a></li>
        </ul>
        <div class="popup-tabs-container">
            <form method="post" action="{{ route('bids.cancel') }}" id="cancel-bid">
                @csrf
                <div class="popup-tab-content" id="tab3" style="">
                    <div class="welcome-text">
                        <h3>Cancel Accept</h3>
                    </div>
                    <input type="text" hidden name="bid_id" id="bid_id_to_cancel">
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="cancel-bid">Cancel <i class="icon-line-awesome-undo"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="small-dialog-4" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
        </ul>
        <div class="popup-tabs-container">
            <div class="popup-tab-content" id="tab4">
                <div class="welcome-text">
                    <h3>Leave a Review</h3>
                    {{--                        <span>Rate <a href="#">Peter Valentín</a> for the project <a href="#">Simple Chrome Extension</a> </span>--}}
                </div>
                <form method="post" id="leave-review-form" action="{{ route('reviews.store') }}">
                    @csrf
                    <input type="text" id="bid_id_review" name="bid_id" hidden>
                    <div class="feedback-yes-no">
                        <strong>Was this delivered on budget?</strong>
                        <div class="radio">
                            <input name="on_budget" type="radio" value="1" required>
                            <label><span class="radio-label"></span> Yes</label>
                        </div>

                        <div class="radio">
                            <input id="radio-2" name="on_budget" type="radio" value="0" required>
                            <label for="radio-2"><span class="radio-label"></span> No</label>
                        </div>
                    </div>

                    <div class="feedback-yes-no">
                        <strong>Was this delivered on time?</strong>
                        <div class="radio">
                            <input id="radio-3" name="on_time" type="radio" value="1" required>
                            <label for="radio-3"><span class="radio-label"></span> Yes</label>
                        </div>
                        <div class="radio">
                            <input id="radio-4" name="on_time" type="radio" value="0" required>
                            <label for="radio-4"><span class="radio-label"></span> No</label>
                        </div>
                    </div>

                    <div class="feedback-yes-no">
                        <strong>Your Rating</strong>
                        <div class="leave-rating">
                            <input type="radio" name="rating" id="rating-radio-1" value="5" required>
                            <label for="rating-radio-1" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-radio-2" value="4" required>
                            <label for="rating-radio-2" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-radio-3" value="3" required>
                            <label for="rating-radio-3" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-radio-4" value="2" required>
                            <label for="rating-radio-4" class="icon-material-outline-star"></label>
                            <input type="radio" name="rating" id="rating-radio-5" value="1" required>
                            <label for="rating-radio-5" class="icon-material-outline-star"></label>
                        </div><div class="clearfix"></div>
                    </div>
                    <textarea class="with-border" placeholder="Comment" name="comments" id="message2" cols="7" required></textarea>
                </form>
                <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="leave-review-form">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i></button>
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
<script>
    $('.button.accept').click(function () {
        let price = $(this).attr('data-price');
        let bid = $(this).attr('data-bid');
        let driverName = $(this).attr('data-driver');
        $('#small-dialog-1').find('.bid-acceptance').html('$' + price);
        $('#bid_id').val(bid);
        $('.welcome-text h3.accept-title').html('Accept Offer From ' + driverName);
    });
    $('.button.message').click(function () {
        let driverName = $(this).attr('data-driver-name');
        let driverId = $(this).attr('data-driver-id');
        $('#driver_id').val(driverId);
        $('.welcome-text h3.message-title').html('Direct Message To ' + driverName);
    });
    $('.button.cancel').click(function () {
        let bid = $(this).attr('data-bid');
        $('#bid_id_to_cancel').val(bid);
    });
    $('.button.leave-review').click(function () {
        let bid = $(this).attr('data-bid');
        $('#bid_id_review').val(bid);
    });
    $('.radio label').click(function () {
        $(this).prev().prop('checked', true);
        // console.log($('input[name="on_budget"]:checked').val());
    });
    $('.leave-rating label').click(function () {
        $(this).prev().prop('checked', true);
        // console.log($('input[name="rating"]:checked').val());
    });
</script>
<script>
    $('#send-pm').submit(function (e) {
        let form = $(this);
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                window.location.reload();
            }
        });
    })
</script>
@if(auth()->check() && auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
