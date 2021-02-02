<div id="footer">

    <!-- Footer Top Section -->
    <div class="footer-top-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Footer Rows Container -->
                    <div class="footer-rows-container">

                        <!-- Left Side -->
                        <div class="footer-rows-left">
                            <div class="footer-row">
                                <div class="footer-row-inner footer-logo">
                                    <img src="{{ asset('images/logo2.png') }}" alt="">
                                </div>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="footer-rows-right">

                            <!-- Social Icons -->
                            <div class="footer-row">
                                <div class="footer-row-inner">
                                    <ul class="footer-social-links">
                                        <li>
                                            <a href="#" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light">
                                                <i class="icon-brand-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light">
                                                <i class="icon-brand-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Footer Rows Container / End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top Section / End -->

    <!-- Footer Middle Section -->
    <div class="footer-middle-section">
        <div class="container">
            <div class="row">

                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <div class="footer-links">
                        <h3>Helpful Links</h3>
                        <ul>
                            <li><a href="{{ route('contact.index') }}"><span>Contact</span></a></li>
                            <li><a href="#"><span>Privacy Policy</span></a></li>
                            <li><a href="#"><span>Terms of Use</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                </div>
                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                </div>
                <!-- Links -->
                <div class="col-xl-2 col-lg-2 col-md-3">
                </div>


                <!-- Newsletter -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                    <p>Weekly breaking news, analysis and cutting edge advices on ride searching.</p>
                    <form action="{{ route('newsletter.register') }}" method="post" class="newsletter">
                        @csrf
                        <input type="text" name="email" placeholder="Enter your email address">
                        <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Middle Section / End -->

    <!-- Footer Copyrights -->
    <div class="footer-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    © 2019 <strong>Youwala</strong>. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</div>
