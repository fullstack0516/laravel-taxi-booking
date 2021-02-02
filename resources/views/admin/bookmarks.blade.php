@extends("layouts.admin")

@section('content')
    <div class="dashboard-headline">
        <h3>Bookmarks</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>Bookmarks</li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-material-outline-business-center"></i> Bookmarked Jobs</h3>
                </div>
                <div class="content">
                    <ul class="dashboard-box-list">
                        <li>
                            <div class="job-listing">
                                <div class="job-listing-details">
                                    <a href="#" class="job-listing-company-logo">
                                        <img src="{{ asset('images/company-logo-02.png') }}" alt="">
                                    </a>
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="#">Barista and Cashier</a></h3>
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-business"></i> Coffee</li>
                                                <li><i class="icon-material-outline-location-on"></i> San Francisco</li>
                                                <li><i class="icon-material-outline-business-center"></i> Full Time</li>
                                                <li><i class="icon-material-outline-access-time"></i> 2 days ago</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons-to-right">
                                <a href="#" class="button red ripple-effect ico" title="Remove" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                            </div>
                        </li>

                        <li>
                            <div class="job-listing">
                                <div class="job-listing-details">
                                    <a href="#" class="job-listing-company-logo">
                                        <img src="{{ asset('images/company-logo-04.png') }}" alt="">
                                    </a>
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="#">Administrative Assistant</a></h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-business"></i> Mates</li>
                                                <li><i class="icon-material-outline-location-on"></i> San Francisco</li>
                                                <li><i class="icon-material-outline-business-center"></i> Full Time</li>
                                                <li><i class="icon-material-outline-access-time"></i> 2 days ago</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right">
                                <a href="#" class="button red ripple-effect ico" title="Remove" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                            </div>
                        </li>

                        <li>
                            <!-- Job Listing -->
                            <div class="job-listing">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Logo -->
                                    <a href="#" class="job-listing-company-logo">
                                        <img src="{{ asset('images/company-logo-05.png') }}" alt="">
                                    </a>

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="#">Construction Labourers</a></h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-business"></i> Podous</li>
                                                <li><i class="icon-material-outline-location-on"></i> San Francisco</li>
                                                <li><i class="icon-material-outline-business-center"></i> Full Time</li>
                                                <li><i class="icon-material-outline-access-time"></i> 2 days ago</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right">
                                <a href="#" class="button red ripple-effect ico" title="Remove" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-face"></i> Bookmarked Drivers</h3>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list">
                        <li>
                            <!-- Overview -->
                            <div class="freelancer-overview">
                                <div class="freelancer-overview-inner">

                                    <!-- Avatar -->
                                    <div class="freelancer-avatar">
                                        <div class="verified-badge"></div>
                                        <a href="#"><img src="{{ asset('images/user-avatar-big-02.jpg') }}" alt=""></a>
                                    </div>

                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4><a href="#">David Peterson <img class="flag" src="{{ asset('images/flags/de.svg') }}" alt="" title="Germany" data-tippy-placement="top"></a></h4>
                                        <span>iOS Expert + Node Dev</span>
                                        <!-- Rating -->
                                        <div class="freelancer-rating">
                                            <div class="star-rating" data-rating="4.2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right">
                                <a href="#" class="button red ripple-effect ico" title="Remove" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                            </div>
                        </li>
                        <li>
                            <!-- Overview -->
                            <div class="freelancer-overview">
                                <div class="freelancer-overview-inner">

                                    <!-- Avatar -->
                                    <div class="freelancer-avatar">
                                        <a href="#"><img src="{{ asset('images/user-avatar-placeholder.png') }}" alt=""></a>
                                    </div>

                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4><a href="#">Marcin Kowalski <img class="flag" src="{{ asset('images/flags/pl.svg') }}" alt="" title="Poland" data-tippy-placement="top"></a></h4>
                                        <span>Front-End Developer</span>
                                        <!-- Rating -->
                                        <div class="freelancer-rating">
                                            <div class="star-rating" data-rating="4.7"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right">
                                <a href="#" class="button red ripple-effect ico" title="Remove" data-tippy-placement="left"><i class="icon-feather-trash-2"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
