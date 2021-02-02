<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
                    <h3>User Information</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Edit User</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    @if($errors->any())
                        <div class="col-xl-12">
                            @foreach($errors->all() as $error)
                                <div class="notification error closeable">
                                    <p>{{ $error }}</p>
                                    <a class="close">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('users.update', ['user' => $user]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">
                                <div class="headline d-flex justify-content-between">
                                    <h3><i class="icon-material-outline-account-circle"></i> User Details</h3>
                                    <div>
                                        @if($user->hasRole('driver'))
                                            <form class="headline-actions" action="{{ route('users.update', ['user' => $user]) }}" method="post">
                                                @csrf
                                                @method('put')
                                                @if($user->approved_at)
                                                    <button class="button">Refuse Now</button>
                                                @else
                                                    <button class="button">Approve Now</button>
                                                @endif
                                            </form>
                                        @endif
                                        <form action="{{ route('users.destroy', ['user' => $user]) }}">

                                        </form>
                                    </div>
                                </div>
                                <div class="content with-padding padding-bottom-0">
                                    <div class="row">

                                        <div class="col-auto">
                                            <div class="avatar-wrapper">
                                                <img
                                                    src="@if($user->profile) {{ $user->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif"
                                                    alt=""/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Account Type @if($user->hasRole('driver')) @if($user->stripeAccount) <span class="badge badge-primary">Payment Verified</span> @endif @if($user->approved_at) <span class="badge badge-primary">Approved</span> @else <span class="badge badge-warning">Unapproved</span> @endif @endif @if($user->phone_verified_at) <span class="badge badge-secondary">Phone Verified</span> @endif @if($user->email_verified_at) <span class="badge badge-success">Email Verified</span> @endif @if(!$user->stripeAccount && !$user->phone_verified_at && !$user->email_verified_at) <span class="badge badge-danger">Unverified</span> @endif</h5>
                                                        <div class="account-type">
                                                            @foreach($currentRoles as $user_role)
                                                            <div class="col-6">
                                                                <input type="radio" name="role" id="employer-radio"
                                                                       class="account-type-radio" value="customer" checked/>
                                                                <label for="employer-radio" class="ripple-effect-dark">
                                                                    <i class="icon-material-outline-business-center"></i> {{ $user_role->name }}</label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Username</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('name', $user->name) }}"
                                                               name="name" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Email</h5>
                                                        <input type="email" class="with-border"
                                                               value="{{ old('email', $user->email) }}"
                                                               name="email" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>First Name</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('first_name', $user->first_name) }}"
                                                               name="first_name" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Last Name</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('last_name', $user->last_name) }}"
                                                               name="last_name" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Phone</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('phone_number', $user->phone_number) }}"
                                                               name="phone_number" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="dashboard-box">
                                <div class="headline">
                                    <h3><i class="icon-material-outline-face"></i> My Profile</h3>
                                </div>
                                <div class="content">
                                    <ul class="fields-ul">
                                        @if($user->hasRole('driver'))
                                            <li id="attachments">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="submit-field">
                                                            <h5>License Image</h5>
                                                            <div class="attachments-container margin-top-0 margin-bottom-0">
                                                                <div class="license-box" id="license-pic">
                                                                    <img class="img-fluid" src="@if($user->car){{ $user->car->license_image }}@endif" alt="No License Image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="submit-field">
                                                            <h5>Car Number</h5>
                                                            <div class="attachments-container margin-top-0 margin-bottom-0">
                                                                <div class="license-box" id="license-pic">
                                                                    <img class="img-fluid" src="@if($user->car){{ $user->car->car_number_plate }}@endif" alt="No Car Number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>License Number</h5>
                                                            <input type="text" class="with-border" value="@if($user->car) {{ $user->car->license_number }} @endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Car Name</h5>
                                                            <input type="text" class="with-border" value="@if($user->car) {{ $user->car->name }} @endif" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="submit-field">
                                                            <h5>Year of Model</h5>
                                                            <input type="text" class="with-border" value="@if($user->car) {{ $user->car->year_of_model }} @endif" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        <li>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Address</h5>
                                                        <div class="keyword-input-container">
                                                            <input type="text" class="keyword-input" id="address" name="address" value="@if($user->profile){{ $user->profile->address }}@endif" placeholder="Input Address" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>City</h5>
                                                        <input value="@if($user_city){{ $user_city->name }}@endif" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="submit-field">
                                                        <h5>Introduce Yourself</h5>
                                                        <textarea name="bio" cols="30" rows="5" class="with-border" readonly>@if($user->profile){!! $user->profile->bio !!}@endif</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
{{--                        <div class="col-xl-12">--}}
{{--                            <button type="submit" class="button ripple-effect big margin-top-30">Save--}}
{{--                                Changes--}}
{{--                            </button>--}}
{{--                        </div>--}}
                    </form>
                </div>
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
    $('#change-avatar').filemanager('image');
    $('#uploadButton').filemanager('image');
</script>
</body>
</html>
