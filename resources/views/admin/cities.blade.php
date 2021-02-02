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
                    <h3>All Cities</h3>
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>All Cities</li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboard-box">
                            <div class="headline d-flex justify-content-between">
                                <h3><i class="icon-line-awesome-building"></i> All Cities</h3>
                                <div>
                                    <a class="button ripple-effect" href="{{ route('cities.create') }}">Register City</a>
                                </div>
                            </div>
                            <div class="content" style="padding: 20px 30px">
                                <table class="table-striped table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        {{--                            <th>ZIP Code</th>--}}
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cities as $city)
                                        <tr>
                                            <td>{{ $city->id }}</td>
                                            <td>{{ $city->name }}</td>
                                            <td>{{ $city->address }}</td>
                                            <td>{{ $city->country_code }}</td>
                                            {{--                                <td>{{ $city->zip_code }}</td>--}}
                                            <td>
                                                {{ $city->created_at->format('Y.m.d') }}
                                            </td>
                                            <td>
                                                {{ $city->updated_at->format('Y.m.d') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('cities.edit', ['city' => $city->id]) }}" class="btn btn-outline-secondary">
                                                    <i class="icon-line-awesome-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $cities->links() }}
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
