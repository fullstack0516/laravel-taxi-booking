<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
                <span class="trigger-title">Dashboard Navigation</span>
            </a>

            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">

                    <ul data-submenu-title="Start">
                        <li @if(request()->routeIs('dashboard')) class="active" @endif>
                            <a href="{{ route('dashboard') }}">
                                <i class="icon-material-outline-dashboard"></i>
                                Dashboard
                            </a>
                        </li>
                        @level(1)
                        <li @if(request()->routeIs('chat.inbox')) class="active" @endif>
                            <a href="{{ route('chat.inbox') }}">
                                <i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag" id="total-unread-count2"></span>
                            </a>
                        </li>
                        {{--                                <li @if(request()->routeIs('reviews.*')) class="active" @endif>--}}
                        {{--                                    <a href="{{ route('reviews.index') }}">--}}
                        {{--                                        <i class="icon-material-outline-rate-review"></i> Reviews--}}
                        {{--                                    </a>--}}
                        {{--                                </li>--}}
                        {{--                                <li @if(request()->routeIs('bookmarks.*')) class="active" @endif>--}}
                        {{--                                    <a href="{{ route('bookmarks.index') }}">--}}
                        {{--                                        <i class="icon-material-outline-star-border"></i> Bookmarks--}}
                        {{--                                    </a>--}}
                        {{--                                </li>--}}
                        @endlevel
                    </ul>
                    @role('customer')
                    <ul data-submenu-title="Organize and Manage">
                        <li @if(request()->routeIs('rides.*')) class="active-submenu" @endif>
                            <a href="#"><i class="icon-material-outline-business-center"></i> Rides</a>
                            <ul>
                                <li>
                                    <a href="{{ route('rides.index') }}">
                                        Manage Rides @if(auth()->user()->rides && auth()->user()->rides()->count() > 0) <span class="nav-tag">{{ auth()->user()->rides()->count() }}</span> @endif
                                    </a>
                                </li>
                                @level(2)
                                <li><a href="{{ route('rides.create') }}">Post a Ride</a></li>
                                @endlevel
                            </ul>
                        </li>
                        <li @if(request()->routeIs('billing-methods.*')) class="active" @endif>
                            <a href="{{ route('billing-methods.index') }}">
                                <i class="icon-line-awesome-credit-card"></i>
                                Billing Methods
                            </a>
                        </li>
                    </ul>
                    @endrole
                    @role('driver')
                    <ul data-submenu-title="Organize and Manage">
                        <li @if(request()->routeIs('rides.*')) class="active" @endif>
                            <a href="{{ route('rides.index') }}"><i class="icon-material-outline-business-center"></i> Browse Rides</a>
                        </li>
                    </ul>
                    @endrole
                    @role('admin')
                    <ul data-submenu-title="Administration">
                        <li @if(request()->routeIs('cities.*')) class="active" @endif>
                            <a href="{{ route('cities.index') }}">
                                <i class="icon-line-awesome-building"></i> Cities
                            </a>
                        </li>
                        <li @if(request()->routeIs('rides.*')) class="active" @endif>
                            <a href="{{ route('rides.index') }}">
                                <i class="icon-line-awesome-car"></i> Rides
                            </a>
                        </li>
                        <li @if(request()->routeIs('users.*')) class="active" @endif>
                            <a href="{{ route('users.index') }}">
                                <i class="icon-line-awesome-users"></i> Users
                            </a>
                        </li>
                        <li @if(request()->routeIs('laravelroles::roles.*')) class="active" @endif>
                            <a href="{{ route('laravelroles::roles.index') }}"><i class="icon-feather-tag"></i> Roles</a>
                        </li>
                    </ul>
                    @endrole
                    <ul data-submenu-title="Account">
                        <li @if(request()->routeIs('settings', 'settings.*')) class="active" @endif>
                            <a href="{{ route('settings') }}">
                                <i class="icon-material-outline-settings"></i>
                                Settings
                            </a>
                        </li>
                        @role('driver')
                        <li @if(request()->routeIs('payment-verification.index')) class="active" @endif>
                            <a href="{{ route('payment-verification.index') }}">
                                <i class="icon-line-awesome-bank"></i>
                                Payment Verification
                            </a>
                        </li>
                        @endrole
                        <li @if(request()->routeIs('settings.password-form')) class="active" @endif>
                            <a href="{{ route('settings.password-form') }}">
                                <i class="icon-material-outline-lock"></i>
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" onclick="document.getElementById('logout-form').submit()">
                                <i class="icon-material-outline-power-settings-new"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
