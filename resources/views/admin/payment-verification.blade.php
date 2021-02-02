@extends("layouts.admin")

@section('content')
    <div class="dashboard-headline">
        <h3>Payment Verification</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>Payment Verification</li>
            </ul>
        </nav>
    </div>
    @if($user->approved_at)
        <div class="notification success closeable">
            <p>Payment Method Verified</p>
            <a class="close"></a>
        </div>
    @else
        <div class="notification error closeable">
            <p>Please verify your payment</p>
            <a class="close"></a>
        </div>
    @endif
    <div class="dashboard-box margin-top-0">
        <div class="headline">
            <h3><i class="icon-line-awesome-credit-card"></i> Individual Information</h3>
        </div>
        <div class="content with-padding">
            <form action="{{ route('payment-verification.verify') }}" method="POST" id="payment_form">
                @csrf
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>First Name</h5>
                                    <input type="text" class="with-border" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Last Name</h5>
                                    <input type="text" class="with-border" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Email</h5>
                                    <input type="email" class="with-border" name="email" value="{{ old('email', $user->email) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Phone Number</h5>
                                    <input type="tel" class="with-border" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Social Security Number</h5>
                                    <input type="text" class="with-border" name="id_number" placeholder="" value="{{ old('id_number') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Year of Birth</h5>
                                            <input type="text" class="with-border" name="dob_year" value="@if($accountObject){{ old('dob_year', $accountObject->individual->dob->year) }}@else{{ old('dob_year') }}@endif" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="submit-field">
                                            <h5>Month of Birth</h5>
                                            <input type="text" class="with-border" name="dob_month" value="@if($accountObject){{ old('dob_month', $accountObject->individual->dob->month) }}@else{{ old('dob_month') }}@endif" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="submit-field">
                                            <h5>Day of Birth</h5>
                                            <input type="text" class="with-border" name="dob_day" value="@if($accountObject){{ old('dob_day', $accountObject->individual->dob->day) }}@else{{ old('dob_day') }}@endif" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Cardholder Name</h5>
                                    <input type="text" class="with-border" name="card_name" value="{{ old('card_name') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Card Number</h5>
                                    <input type="text" class="with-border" name="card_number" value="{{ old('card_number') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Expiration month</h5>
                                    <input type="text" class="with-border" name="card_exp_month" value="{{ old('card_exp_month') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Expiration Year</h5>
                                    <input type="text" class="with-border" name="card_exp_year" value="{{ old('card_exp_month') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>CVC</h5>
                                    <input type="text" class="with-border" name="card_cvc" value="{{ old('card_cvc') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Address Line 1</h5>
                                    <input type="text" class="with-border" name="address_line1" value="@if($accountObject){{ old('address_line1', $accountObject->individual->address->line1) }}@else{{ old('address_line1') }}@endif" placeholder="e.g., street, PO Box, or company name" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Address Line 2</h5>
                                    <input type="text" class="with-border" name="address_line2" value="@if($accountObject){{ old('address_line2', $accountObject->individual->address->line2) }}@else{{ old('address_line2') }}@endif" placeholder="e.g., apartment, suite, unit, or building" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>City</h5>
                                    <input type="text" class="with-border" name="city" value="@if($accountObject){{ old('city', $accountObject->individual->address->city) }}@else{{ old('city') }}@endif" placeholder="" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>State</h5>
                                    <input type="text" class="with-border" name="state" value="@if($accountObject){{ old('state', $accountObject->individual->address->state) }}@else{{ old('state') }}@endif" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="button big ripple-effect margin-top-32 margin-bottom-32" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
