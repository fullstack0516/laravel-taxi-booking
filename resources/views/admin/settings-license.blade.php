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
                    <form action="{{ route('settings.store-license') }}" method="post" class="col-xl-12">
                        @csrf
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-outline-face"></i> Driver License</h3>
                            </div>
                            <div class="content with-padding">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>License Number</h5>
                                            <input class="with-border" type="text" name="license_number" value="@if($user->car){{ old('license_number', $user->car->license_number) }}@else{{ old('license_number') }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Car Name</h5>
                                            <input class="with-border" type="text" name="car_name" value="@if($user->car){{ old('car_name', $user->car->name) }}@else{{ old('car_name') }}@endif">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>Year of Model</h5>
                                            <input class="with-border" type="text" name="year_of_model" value="@if($user->car){{ old('year_of_model', $user->car->year_of_model) }}@else{{ old('year_of_model') }}@endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <div class="uploadButton margin-top-15">
                                                <label id="uploadButton" class="uploadButton-button ripple-effect" for="upload" data-input="license_image" data-preview="license-pic">Upload
                                                    License Image
                                                </label>
                                                <input type="text" id="license_image" name="license_image" value="@if($user->car){{ old('license_image', $user->car->license_image) }}@else{{ old('license_image') }}@endif" hidden>
                                            </div>
                                        </div>
                                        <div id="license-pic" class="margin-top-15">
                                            <img src="@if($user->car){{ old('license_image', $user->car->license_image) }}@else{{ old('license_image') }}@endif" alt="License Image">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <div class="uploadButton margin-top-15">
                                                <label id="uploadPlateButton" class="uploadButton-button ripple-effect" data-input="number_image" data-preview="number-pic">
                                                    Upload Car Number Plate
                                                </label>
                                                <input type="text" id="number_image" name="car_number_plate" value="@if($user->car){{ old('car_number_plate', $user->car->car_number_plate) }}@else{{ old('car_number_plate') }}@endif" hidden>
                                            </div>
                                        </div>
                                        <div id="number-pic" class="margin-top-15">
                                            <img src="@if($user->car){{ old('car_number_plate', $user->car->car_number_plate) }}@else{{ old('car_number_plate') }}@endif" alt="Car Number Plate">
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-field margin-top-25">
                                    <h5>Introduce Yourself</h5>
                                    <textarea name="bio" cols="30" rows="5" class="with-border">{!! old('bio', $user->profile->bio) !!}</textarea>
                                </div>
                                <div class="submit-field d-flex">
                                    <a href="{{ route('settings.show-address') }}" class="button ripple-effect">
                                        <i class="icon-line-awesome-step-backward"></i> Previous
                                    </a>
                                    <button type="submit" class="button ripple-effect margin-left-20">
                                        <i class="icon-line-awesome-save"></i> Save Changes
                                    </button>
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
    $('#uploadButton').filemanager('image');
    $('#uploadPlateButton').filemanager('image');
</script>

@if(auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
