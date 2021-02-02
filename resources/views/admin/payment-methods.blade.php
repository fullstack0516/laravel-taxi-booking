@extends("layouts.admin")

@section('content')
    <div class="dashboard-headline">
        <h3>Payment Methods</h3>
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>Payment Methods</li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-xl-6 margin-top-16">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-line-awesome-credit-card"></i> Payment Methods</h3>
                </div>
                <div class="content with-padding">

                </div>
            </div>
{{--            <div class="clearfix"></div>--}}
{{--            <div class="pagination-container margin-top-40 margin-bottom-0">--}}
{{--                <nav class="pagination">--}}
{{--                    <ul>--}}
{{--                        <li><a href="#" class="ripple-effect current-page">1</a></li>--}}
{{--                        <li><a href="#" class="ripple-effect">2</a></li>--}}
{{--                        <li><a href="#" class="ripple-effect">3</a></li>--}}
{{--                        <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>--}}
{{--                    </ul>--}}
{{--                </nav>--}}
{{--            </div>--}}
{{--            <div class="clearfix"></div>--}}
        </div>
        <div class="col-xl-6 margin-top-16">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-line-awesome-cc-mastercard"></i>Add Payment Method</h3>
                </div>
                <div class="content with-padding">
                    <form action="{{ route('payment-methods.store') }}" method="POST" id="payment_form">
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
                        <button class="button big ripple-effect margin-top-32 margin-bottom-32" id="pay_button" type="submit" data-secret="{{ $intent->client_secret }}">Add Debit Card</button>
                    </form>
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
@endsection
