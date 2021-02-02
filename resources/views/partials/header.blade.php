<header id="header-container" class="fullwidth">

    <!-- Header -->
    <div id="header">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                </div>

                <!-- Main Navigation -->
                <nav id="navigation">
                    <ul id="responsive">

                        <li>
                            <a href="{{ url('/') }}" class="current">Home</a>
                        </li>
                        @if(auth()->check() && auth()->user()->hasRole('driver'))
                            <li>
                                <a href="{{ route('rides.index') }}">Browse Rides</a>
                            </li>
                        @elseif(auth()->guest())
                            <li>
                                <a href="{{ route('rides.index') }}">Browse Rides</a>
                            </li>
                        @endif
{{--                        @if(auth()->guest() || (auth()->check() && auth()->user()->hasRole('customer')))--}}
{{--                            <li>--}}
{{--                                <a href="{{ url('drivers') }}">Find a Driver</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
                        @guest
                            <li>
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">Register</a>
                            </li>
                        @endguest

                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->

            </div>
            <!-- Left Side Content / End -->


            <!-- Right Side Content / End -->
            <div class="right-side">

                @if(auth()->check())
                <!--  User Notifications -->
                <div class="header-widget hide-on-mobile">

                    <!-- Notifications -->
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

{{--                    <!-- Messages -->--}}
{{--                    <div class="header-notifications">--}}
{{--                        <div class="header-notifications-trigger">--}}
{{--                            <a href="#"><i class="icon-feather-mail"></i><span>3</span></a>--}}
{{--                        </div>--}}

{{--                        <!-- Dropdown -->--}}
{{--                        <div class="header-notifications-dropdown">--}}

{{--                            <div class="header-notifications-headline">--}}
{{--                                <h4>Messages</h4>--}}
{{--                                <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">--}}
{{--                                    <i class="icon-feather-check-square"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}

{{--                            <div class="header-notifications-content">--}}
{{--                                <div class="header-notifications-scroll" data-simplebar>--}}
{{--                                    <ul>--}}
{{--                                        <!-- Notification -->--}}
{{--                                        <li class="notifications-not-read">--}}
{{--                                            <a href="dashboard-messages.html">--}}
{{--                                                <span class="notification-avatar status-online"><img src="images/user-avatar-small-03.jpg" alt=""></span>--}}
{{--                                                <div class="notification-text">--}}
{{--                                                    <strong>David Peterson</strong>--}}
{{--                                                    <p class="notification-msg-text">Thanks for reaching out. I'm quite busy right now on many...</p>--}}
{{--                                                    <span class="color">4 hours ago</span>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <!-- Notification -->--}}
{{--                                        <li class="notifications-not-read">--}}
{{--                                            <a href="dashboard-messages.html">--}}
{{--                                                <span class="notification-avatar status-offline"><img src="images/user-avatar-small-02.jpg" alt=""></span>--}}
{{--                                                <div class="notification-text">--}}
{{--                                                    <strong>Sindy Forest</strong>--}}
{{--                                                    <p class="notification-msg-text">Hi Tom! Hate to break it to you, but I'm actually on vacation until...</p>--}}
{{--                                                    <span class="color">Yesterday</span>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}

{{--                                        <!-- Notification -->--}}
{{--                                        <li class="notifications-not-read">--}}
{{--                                            <a href="dashboard-messages.html">--}}
{{--                                                <span class="notification-avatar status-online"><img src="images/user-avatar-placeholder.png" alt=""></span>--}}
{{--                                                <div class="notification-text">--}}
{{--                                                    <strong>Marcin Kowalski</strong>--}}
{{--                                                    <p class="notification-msg-text">I received payment. Thanks for cooperation!</p>--}}
{{--                                                    <span class="color">Yesterday</span>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <a href="dashboard-messages.html" class="header-notifications-button ripple-effect button-sliding-icon">View All Messages<i class="icon-material-outline-arrow-right-alt"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
                @endif
                <!--  User Notifications / End -->
                @if(auth()->check())
                    <div class="header-widget">
                        <div class="header-notifications user-menu">
                            <div class="header-notifications-trigger">
                                <a href="#">
                                    <div class="user-avatar status-online">
                                        <img
                                            src="@if(auth()->user()->profile && auth()->user()->profile->avatar) {{ auth()->user()->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif"
                                            alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="header-notifications-dropdown">
                                <div class="user-status">
                                    <div class="user-details">
                                        <div class="user-avatar status-online">
                                            <img
                                                src="@if(auth()->user()->profile && auth()->user()->profile->avatar) {{ auth()->user()->profile->avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif"
                                                alt="">
                                        </div>
                                        <div class="user-name">
                                            {{ auth()->user()->name }} <span>@role('driver') Driver @endrole @role('customer') Customer @endrole</span>
                                        </div>
                                    </div>
                                    <div class="status-switch" id="snackbar-user-status">
                                        <label class="user-online current-status">Online</label>
                                        <label class="user-invisible">Invisible</label>
                                        <span class="status-indicator" aria-hidden="true"></span>
                                    </div>
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
                @endif
            <!-- Mobile Navigation Button -->
                <span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

            </div>
            <!-- Right Side Content / End -->

        </div>
    </div>
    <!-- Header / End -->

</header>
<div class="clearfix"></div>
