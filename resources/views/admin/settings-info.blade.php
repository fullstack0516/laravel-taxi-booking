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
                    <h3>Settings</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Settings</li>
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
                    <form action="{{ route('settings.store-info') }}" method="post">
                        @csrf
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">
                                <div class="headline">
                                    <h3><i class="icon-material-outline-account-circle"></i> My Profile</h3>
                                </div>
                                <div class="content with-padding padding-bottom-0">
                                    <div class="row">

                                        <div class="col-auto">
                                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar" id="profile-pic">
                                                <img
                                                    src="@if($user->profile->avatar) {{ $user->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif"
                                                    alt=""/>
                                                {{--                                <input class="file-upload" type="file" accept="image/*"/>--}}
                                            </div>
                                            <button class="upload-button" id="change-avatar" data-input="avatar-path" data-preview="profile-pic"></button>
                                            <input type="text" id="avatar-path" name="avatar"
                                                   value="{{ old('avatar', $user->profile->avatar) }}" hidden>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Username</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('name', $user->name) }}"
                                                               name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Email</h5>
                                                        <input type="email" class="with-border"
                                                               value="{{ old('email', $user->email) }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>First Name</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('first_name', $user->first_name) }}"
                                                               name="first_name" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Last Name</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('last_name', $user->last_name) }}"
                                                               name="last_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>Phone</h5>
                                                        <input type="text" class="with-border"
                                                               value="{{ old('phone_number', $user->phone_number) }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="submit-field d-flex">
                                                        <a href="{{ route('settings') }}" class="button ripple-effect">
                                                            <i class="icon-line-awesome-step-backward"></i> Previous
                                                        </a>
                                                        <button type="submit" class="button ripple-effect margin-left-20">
                                                            Next <i class="icon-line-awesome-step-forward"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
</script>
@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
