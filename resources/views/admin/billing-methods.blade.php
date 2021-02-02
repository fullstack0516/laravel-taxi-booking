<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
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
                    <h3>Billing Methods</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Billing Methods</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-box margin-top-0">
                            <div class="headline">
                                <h3>Billing Methods</h3>
                                <button class="mark-as-read ripple-effect-dark" data-toggle="modal" data-target="#methodModal" data-tippy-placement="left" data-tippy="" data-original-title="Add Method">
                                    <i class="icon-feather-plus"></i>
                                </button>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($paymentMethods as $paymentMethod)
                                        @php
                                            $stripeMethod = $paymentMethod->asStripePaymentMethod();
                                            $logo = null;
                                            switch ($stripeMethod->card->brand) {
                                                case 'visa':
                                                    $logo = asset('images/brands/visa.png');
                                                    break;
                                                case 'mastercard':
                                                    $logo = asset('images/brands/mastercard.png');
                                                    break;
                                                case 'amex':
                                                    $logo = asset('images/brands/express.png');
                                                    break;
                                                case 'discover':
                                                    $logo = asset('images/brands/discover.png');
                                                    break;
                                                default:
                                                    $logo = null;
                                            }
                                        @endphp
                                    <li>
                                        <div class="job-listing">
                                            <div class="job-listing-details">

                                                <!-- Logo -->
                                                <a href="#" class="job-listing-company-logo">
                                                    <img src="{{ $logo }}" alt="{{ $stripeMethod->card->brand }}">
                                                </a>

                                                <!-- Details -->
                                                <div class="job-listing-description">
                                                    <h3 class="job-listing-title"><span>****-****-****-****-{{ $stripeMethod->card->last4 }}</span><span class="margin-left-20 margin-right-10">{{ $stripeMethod->card->exp_month }}</span>/<span class="margin-left-10">{{ $stripeMethod->card->exp_year }}</span></h3>
                                                </div>
                                            </div>
                                            <div class="buttons-to-right single-right-button">
                                                <a href="#" class="button red ripple-effect ico" data-tippy-placement="left" data-tippy="" data-original-title="Remove"><i class="icon-feather-trash-2"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-footer-spacer"></div>
                @include('partials.admin-footer')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="methodModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Add Billing Method
            </div>
            <div class="modal-body">
                <form action="{{ route('billing-methods.store') }}" method="POST" id="payment_form">
                    @csrf
                    <div class="form-group">
                        <label>Card Name</label>
                        <input id="nameOnCard" class="form-control" name="nameOnCard" required type="text" placeholder="Cardholder Name">
                        <input id="payment_method" name="payment_method" type="hidden">
                    </div>
                    <div class="form-group">
                        <label>Card Details</label>
                        <div id="card-element" class="margin-top-20">
                        </div>
                        <div id="card-errors" role="alert"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="button ripple-effect" id="pay_button" form="payment_form" type="submit" data-secret="{{ $intent->client_secret }}">Add Method</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.4.1/js/bootstrap.bundle.js') }}"></script>
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
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var cardElement = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    cardElement.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    const cardHolderName = document.getElementById('nameOnCard');
    const submitButton = document.getElementById('pay_button');
    const clientSecret = submitButton.dataset.secret;

    submitButton.addEventListener('click', async (e) => {
        submitButton.disabled = true;
        e.preventDefault();
        if (cardHolderName.value === '') {
            Snackbar.show({
                text: 'Name on card not empty',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#dc3139'
            });
            submitButton.disabled = false;
            return;
        }
        const { setupIntent, error } = await stripe.handleCardSetup(
            clientSecret, cardElement, {
                payment_method_data: {
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
            console.log(error);
            Snackbar.show({
                text: 'Unverified',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#dc3139'
            });
            submitButton.disabled = false;
        } else {
            $('#payment_method').val(setupIntent.payment_method);
            $('#payment_form').submit();
        }
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
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
