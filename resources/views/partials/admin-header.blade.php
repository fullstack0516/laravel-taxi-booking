<header id="header-container" class="fullwidth dashboard-header not-sticky">
    <div id="header">
        <div class="container">
            <div class="left-side">
                <div id="logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                </div>
                <nav id="navigation">
                    <ul id="responsive">
                        @role('driver')
                        <li><a href="{{ route('rides.index') }}">Browse Rides</a></li>
                        @endrole
                        @role('customer')
                        <li><a href="#">Find a Driver</a></li>
                        <li><a href="{{ route('rides.create') }}">Post a Ride</a></li>
                        @endrole
                    </ul>
                </nav>
                <div class="clearfix"></div>
            </div>
            <div class="right-side">
                @if(auth()->check() && auth()->user()->hasRole(['customer', 'driver', 'admin']))
                    <div class="header-widget hide-on-mobile">
                        <div class="header-notifications">
                            <div class="header-notifications-trigger">
                                <a href="#"><i class="icon-feather-bell"></i>@if(auth()->user()->unreadNotifications->count() > 0) <span> {{ auth()->user()->unreadNotifications->count() }} </span> @endif</a>
                            </div>
                            <div class="header-notifications-dropdown">
                                <div class="header-notifications-headline">
                                    <h4>Notifications</h4>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left" form="mark-as-read">
                                            <i class="icon-feather-check-square"></i>
                                        </button>
                                        <form id="mark-as-read" action="{{ route('notifications.update-all') }}" method="post">
                                            @csrf
                                            @method('put')
                                        </form>
                                    @endif
                                </div>

                                <div class="header-notifications-content">
                                    <div class="header-notifications-scroll" data-simplebar>
                                        <ul>
                                            <!-- Notification -->
                                            @if(auth()->user()->unreadNotifications->count() > 0)
                                                @foreach(auth()->user()->unreadNotifications as $notification)
                                                <li class="notifications-not-read">
                                                    <a href="#">
                                                        <span class="notification-icon"><i class="icon-material-outline-group"></i></span>
                                                        <span class="notification-text">
                                                            {{ $notification->data['title'] }}
                                                        </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            @else
                                                <li class="notifications-not-read">
                                                    <a href="#" style="justify-content: center;">
                                                        <span>
                                                            <strong>No Notifications</strong>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-notifications">
                            <div class="header-notifications-trigger">
                                <a href="{{ route('chat.inbox') }}"><i class="icon-feather-mail"></i><span id="total-unread-count"></span></a>
                            </div>
{{--                            <div class="header-notifications-dropdown">--}}
{{--                                <div class="header-notifications-headline">--}}
{{--                                    <h4>Messages</h4>--}}
{{--                                    <button class="mark-as-read ripple-effect-dark" title="Mark all as read"--}}
{{--                                            data-tippy-placement="left">--}}
{{--                                        <i class="icon-feather-check-square"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <div class="header-notifications-content">--}}
{{--                                    <div class="header-notifications-scroll" data-simplebar>--}}
{{--                                        <ul id="unread-messages">--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <a href="{{ route('chat.inbox') }}" class="header-notifications-button ripple-effect button-sliding-icon">View All Messages<i class="icon-material-outline-arrow-right-alt"></i></a>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                @endif
                <div class="header-widget">
                    <div class="header-notifications user-menu">
                        <div class="header-notifications-trigger">
                            <a href="#">
                                <div class="user-avatar status-online">
                                    <img src="@if(auth()->user()->profile->avatar) {{ auth()->user()->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="header-notifications-dropdown">
                            <div class="user-status">
                                <div class="user-details">
                                    <div class="user-avatar status-online">
                                        <img src="@if(auth()->user()->profile->avatar) {{ auth()->user()->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif" alt="">
                                    </div>
                                    <div class="user-name">
                                        {{ auth()->user()->name }} <span>@role('driver') Driver @endrole @role('customer') Customer @endrole</span>
                                    </div>
                                </div>
                                @level(1)
                                <div class="status-switch" id="snackbar-user-status">
                                    <label class="user-online current-status">Online</label>
                                    <label class="user-invisible">Invisible</label>
                                    <span class="status-indicator" aria-hidden="true"></span>
                                </div>
                                @endlevel
                            </div>
                            <ul class="user-menu-small-nav">
                                <li>
                                    <a href="{{ route('dashboard') }}">
                                        <i class="icon-material-outline-dashboard"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings') }}">
                                        <i class="icon-material-outline-settings"></i> Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                       onclick="document.getElementById('logout-form').submit()">
                                        <i class="icon-material-outline-power-settings-new"></i> Logout
                                    </a>
                                </li>
                                <form style="display: none" action="{{ route('logout') }}" method="post"
                                      id="logout-form">
                                    @csrf
                                </form>
                            </ul>

                        </div>
                    </div>
                </div>
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>
            </div>
        </div>
    </div>
</header>
