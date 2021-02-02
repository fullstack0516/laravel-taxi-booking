<div class="full-page-content-inner">

    <h3 class="page-title">Search Results</h3>

    {{--                <div class="notify-box margin-top-15">--}}
    {{--                    <div class="switch-container">--}}
    {{--                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span class="switch-text">Turn on email alerts for this search</span></label>--}}
    {{--                    </div>--}}
    {{--                    <div class="sort-by">--}}
    {{--                        <span>Sort by:</span>--}}
    {{--                        <select class="selectpicker hide-tick">--}}
    {{--                            <option>Relevance</option>--}}
    {{--                            <option>Newest</option>--}}
    {{--                            <option>Oldest</option>--}}
    {{--                            <option>Random</option>--}}
    {{--                        </select>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    <div class="listings-container compact-list-layout margin-top-35 margin-bottom-25">
        @foreach($rides as $ride)
            <a href="{{ route('rides.show', ['ride' => $ride]) }}" class="job-listing">
                <div class="job-listing-details">
                    <div class="job-listing-company-logo">
                        <img src="{{ $ride->owner->profile->avatar }}" alt="">
                    </div>
                    <div class="job-listing-description">
                        <h3 class="job-listing-title">{{ $ride->title }} @if(auth()->user() && $ride->bids()->where('driver_id', auth()->user()->id)->first()) <span class="badge badge-success">Applied</span> @endif</h3>
                        <div class="job-listing-footer">
                            <ul>
                                <li><i class="icon-material-outline-business"></i> {{ $ride->owner->name }}
                                    @if($ride->owner->hasVerifiedEmail())<div class="verified-badge" title="Email Verified Employer" data-tippy-placement="top" style="background-color: #28a745"></div>@endif
                                    @if($ride->owner->hasVerifiedPhone())<div class="verified-badge" title="Phone Verified Employer" data-tippy-placement="top" style="background-color: #17a2b8"></div>@endif
                                </li>
                                <li><i class="icon-material-outline-access-time"></i> {{ $ride->updated_at->diffForHumans() }}</li>
                                <li><strong>From</strong> <i class="icon-material-outline-location-on"></i> {{ $ride->address_from }}</li>
                                <li><strong>To</strong> <i class="icon-material-outline-location-off"></i> {{ $ride->address_to }}</li>
                                <li><strong>Time</strong> <i class="icon-material-outline-access-time"></i> {{ $ride->time_from->format('M j, Y, G:i') }}</li>
                                {{--                                        <li><strong>To</strong> <i class="icon-material-outline-access-time"></i> {{ $ride->time_to->format('M j, Y, G:i') }}</li>--}}
                            </ul>
                        </div>
                    </div>
                    <span class="bookmark-icon"></span>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="clearfix"></div>
    <div class="pagination-container margin-top-20 margin-bottom-20">
        {{ $rides->links() }}
    </div>
    <div class="clearfix"></div>
    <!-- Pagination / End -->

    <!-- Footer -->
    <div class="small-footer margin-top-15">
        <div class="small-footer-copyrights">
            © 2019 <strong>Youwala.com</strong>. All Rights Reserved.
        </div>
        <ul class="footer-social-links">
            <li>
                <a href="#" title="Facebook" data-tippy-placement="top">
                    <i class="icon-brand-facebook-f"></i>
                </a>
            </li>
            <li>
                <a href="#" title="Twitter" data-tippy-placement="top">
                    <i class="icon-brand-twitter"></i>
                </a>
            </li>
            <li>
                <a href="#" title="Google Plus" data-tippy-placement="top">
                    <i class="icon-brand-google-plus-g"></i>
                </a>
            </li>
            <li>
                <a href="#" title="LinkedIn" data-tippy-placement="top">
                    <i class="icon-brand-linkedin-in"></i>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- Footer / End -->

</div>
