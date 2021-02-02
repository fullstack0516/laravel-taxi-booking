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
                @if(auth()->user()->hasRole('driver') && !auth()->user()->approved_at)
                    <div class="notification error closeable">
                        <p>Platform administrator is checking your profile. Please wait for approving.</p>
                        <a class="close">
                        </a>
                    </div>
                    <br />
                @endif
                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Messages</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>Messages</li>
                        </ul>
                    </nav>
                </div>

                <div class="messages-container margin-top-0">

                    <div class="messages-container-inner">

                        <!-- Messages -->
                        <div class="messages-inbox">
                            <div class="messages-headline">
                                <div class="input-with-icon">
                                    <input id="autocomplete-input" type="text" placeholder="Search">
                                    <i class="icon-material-outline-search"></i>
                                </div>
                            </div>

                            <ul id="rooms-list">
                            </ul>
                        </div>
                        <!-- Messages / End -->

                        <!-- Message Content -->
                        <div class="message-content">

                            <div class="messages-headline">
                                <h4 id="selected-username"></h4>
{{--                                <a href="#" class="message-action"><i class="icon-feather-trash-2"></i> Delete Conversation</a>--}}
                            </div>

                            <!-- Message Content Inner -->
                            <div class="message-content-inner">
                            </div>
                            <!-- Message Content Inner / End -->

                            <!-- Reply Area -->
                            <div class="message-reply" style="display: none;">
                                <textarea cols="1" rows="1" placeholder="Your Message" id="message-content" data-autoresize></textarea>
                                <button class="button ripple-effect" id="send-message">Send</button>
                            </div>

                        </div>
                        <!-- Message Content -->

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
@include('scripts.chatkit')
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
@if(auth()->check() && auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
