@extends('layouts.admin')

@section('content')
    <div class="dashboard-headline">
        <h3>Reviews</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>Reviews</li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-material-outline-business"></i> Rate Customers</h3>
                </div>
                <div class="content">
                    <ul class="dashboard-box-list">
                        <li>
                            <div class="boxed-list-item">
                                <div class="item-content">
                                    <h4>Simple Chrome Extension</h4>
                                    <span class="company-not-rated margin-bottom-5">Not Rated</span>
                                </div>
                            </div>
                            <a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Adsense Expert</h4>
                                    <span class="company-not-rated margin-bottom-5">Not Rated</span>
                                </div>
                            </div>

                            <a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Fix Python Selenium Code</h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> May 2019</div>
                                    </div>
                                    <div class="item-description">
                                        <p>Great clarity in specification and communication. I got payment really fast. Really recommend this employer for his professionalism. I will work for him again with pleasure.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="#small-dialog-1" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i class="icon-feather-edit"></i> Edit Review</a>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>PHP Core Website Fixes</h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> May 2019</div>
                                    </div>
                                    <div class="item-description">
                                        <p>Great clarity in specification and communication. I got payment really fast. Really recommend this employer for his professionalism. I will work for him again with pleasure.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="#small-dialog-1" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i class="icon-feather-edit"></i> Edit Review</a>
                        </li>

                    </ul>
                </div>
            </div>

            <!-- Pagination -->
            <div class="clearfix"></div>
            <div class="pagination-container margin-top-40 margin-bottom-0">
                <nav class="pagination">
                    <ul>
                        <li><a href="#" class="ripple-effect current-page">1</a></li>
                        <li><a href="#" class="ripple-effect">2</a></li>
                        <li><a href="#" class="ripple-effect">3</a></li>
                        <li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                    </ul>
                </nav>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-xl-6">
            <div class="dashboard-box margin-top-0">
                <div class="headline">
                    <h3><i class="icon-material-outline-face"></i> Rate Drivers</h3>
                </div>
                <div class="content">
                    <ul class="dashboard-box-list">
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Simple Chrome Extension</h4>
                                    <span class="company-not-rated margin-bottom-5">Not Rated</span>
                                </div>
                            </div>

                            <a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                        </li>
                        <li>
                            <div class="boxed-list-item">
                                <!-- Content -->
                                <div class="item-content">
                                    <h4>Help Fix Laravel PHP issue</h4>
                                    <div class="item-details margin-top-10">
                                        <div class="star-rating" data-rating="5.0"></div>
                                        <div class="detail-item"><i class="icon-material-outline-date-range"></i> August 2019</div>
                                    </div>
                                    <div class="item-description">
                                        <p>Excellent programmer - helped me fixing small issue.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="#small-dialog-1" class="popup-with-zoom-anim button gray ripple-effect margin-top-5 margin-bottom-10"><i class="icon-feather-edit"></i> Edit Review</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab1">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>Change Review</h3>
                        <span>Rate <a href="#">Herman Ewout</a> for the project <a href="#">WordPress Theme Installation</a> </span>
                    </div>

                    <!-- Form -->
                    <form method="post" id="change-review-form">

                        <div class="feedback-yes-no">
                            <strong>Was this delivered on budget?</strong>
                            <div class="radio">
                                <input id="radio-rating-1" name="radio" type="radio" checked>
                                <label for="radio-rating-1"><span class="radio-label"></span> Yes</label>
                            </div>

                            <div class="radio">
                                <input id="radio-rating-2" name="radio" type="radio">
                                <label for="radio-rating-2"><span class="radio-label"></span> No</label>
                            </div>
                        </div>

                        <div class="feedback-yes-no">
                            <strong>Was this delivered on time?</strong>
                            <div class="radio">
                                <input id="radio-rating-3" name="radio2" type="radio" checked>
                                <label for="radio-rating-3"><span class="radio-label"></span> Yes</label>
                            </div>

                            <div class="radio">
                                <input id="radio-rating-4" name="radio2" type="radio">
                                <label for="radio-rating-4"><span class="radio-label"></span> No</label>
                            </div>
                        </div>

                        <div class="feedback-yes-no">
                            <strong>Your Rating</strong>
                            <div class="leave-rating">
                                <input type="radio" name="rating" id="rating-1" value="1" checked/>
                                <label for="rating-1" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-2" value="2"/>
                                <label for="rating-2" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-3" value="3"/>
                                <label for="rating-3" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-4" value="4"/>
                                <label for="rating-4" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-5" value="5"/>
                                <label for="rating-5" class="icon-material-outline-star"></label>
                            </div><div class="clearfix"></div>
                        </div>

                        <textarea class="with-border" placeholder="Comment" name="message" id="message" cols="7" required>Excellent programmer - helped me fixing small issue.</textarea>

                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="change-review-form">Save Changes <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>
    <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab2">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>Leave a Review</h3>
                        <span>Rate <a href="#">Peter Valentín</a> for the project <a href="#">Simple Chrome Extension</a> </span>
                    </div>

                    <!-- Form -->
                    <form method="post" id="leave-review-form">

                        <div class="feedback-yes-no">
                            <strong>Was this delivered on budget?</strong>
                            <div class="radio">
                                <input id="radio-1" name="radio" type="radio" required>
                                <label for="radio-1"><span class="radio-label"></span> Yes</label>
                            </div>

                            <div class="radio">
                                <input id="radio-2" name="radio" type="radio" required>
                                <label for="radio-2"><span class="radio-label"></span> No</label>
                            </div>
                        </div>

                        <div class="feedback-yes-no">
                            <strong>Was this delivered on time?</strong>
                            <div class="radio">
                                <input id="radio-3" name="radio2" type="radio" required>
                                <label for="radio-3"><span class="radio-label"></span> Yes</label>
                            </div>

                            <div class="radio">
                                <input id="radio-4" name="radio2" type="radio" required>
                                <label for="radio-4"><span class="radio-label"></span> No</label>
                            </div>
                        </div>

                        <div class="feedback-yes-no">
                            <strong>Your Rating</strong>
                            <div class="leave-rating">
                                <input type="radio" name="rating" id="rating-radio-1" value="1" required>
                                <label for="rating-radio-1" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-radio-2" value="2" required>
                                <label for="rating-radio-2" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-radio-3" value="3" required>
                                <label for="rating-radio-3" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-radio-4" value="4" required>
                                <label for="rating-radio-4" class="icon-material-outline-star"></label>
                                <input type="radio" name="rating" id="rating-radio-5" value="5" required>
                                <label for="rating-radio-5" class="icon-material-outline-star"></label>
                            </div><div class="clearfix"></div>
                        </div>

                        <textarea class="with-border" placeholder="Comment" name="message2" id="message2" cols="7" required></textarea>

                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="leave-review-form">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>
@endsection
