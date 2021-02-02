@extends("layouts.admin")

@section('content')
    <div class="dashboard-headline">
        <h3>Checkout</h3>
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>Checkout Bid</li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 content-right-offset">
                <h3 class="margin-top-50">Payment Method</h3>
                <div class="payment margin-top-30">
                    <div class="payment-tab payment-tab-active">
                        <div class="payment-tab-trigger">
                            <input type="radio" name="cardType" id="creditCart" value="creditCard" checked>
                            <label for="creditCart">Credit / Debit Card</label>
                        </div>
                        <div class="payment-tab-content">
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <div class="notification error closeable">
                                        <p>{{ $error }}</p>
                                        <a class="close">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                            <form method="post" action="{{ route('bids.checkout', ['bid' => $bid->id]) }}" id="checkout-bid">
                                @csrf
                                <div class="row payment-form-row">
                                    <div class="col-md-6">
                                        <div class="card-label">
                                            <input id="nameOnCard" name="nameOnCard" required type="text" placeholder="Cardholder Name">
                                        </div>
                                        <input id="payment_method" name="payment_method" type="text" hidden>
                                    </div>
                                    <div class="col-md-12 margin-top-20">
                                        <label>Card Details</label>
                                        <div id="card-element">
                                        </div>
                                        <div id="card-errors" role="alert"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button class="button big ripple-effect margin-top-40 margin-bottom-65" id="pay_button" type="submit" data-secret="{{ $intent->client_secret }}" form="checkout-bid">Proceed Payment</button>
            </div>
            <div class="col-xl-4 col-lg-4 margin-top-0 margin-bottom-60">
                <div class="boxed-widget summary margin-top-0">
                    <div class="boxed-widget-headline">
                        <h3>Summary</h3>
                    </div>
                    <div class="boxed-widget-inner">
                        <ul>
                            <li>Candidate <span>{{ $bid->driver->first_name.' '.$bid->driver->last_name }}</span></li>
                            <li class="total-costs">Price <span>${{ $bid->price }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="checkbox margin-top-30">
                    <input type="checkbox" id="two-step">
                    <label for="two-step"><span class="checkbox-icon"></span>  I agree to the <a href="#">Terms and Conditions</a> and the <a href="#">Automatic Renewal Terms</a></label>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
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
            e.preventDefault();
            const { setupIntent, error } = await stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
            } else {
                $('#payment_method').val(setupIntent.payment_method);
                $('#checkout-bid').submit();
            }
        });
    </script>
    @if(session('error'))
        <script>
            $(document).ready(function() {
                Snackbar.show({
                    text: '{{ session('error') }}',
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
@endsection
