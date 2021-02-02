<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

@include('partials.header')

<!-- Content / Start -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Contact</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-xl-12">
                <div class="contact-location-info margin-bottom-50">
                    <div class="contact-address">
                        <ul>
                            <li class="contact-address-headline">Our Office</li>
                            <li>425 Berry Street, CA 93584</li>
                            <li>Phone (123) 123-456</li>
                            <li><a href="#">support@youwala.com</a></li>
                            <li>
                                <div class="freelancer-socials">
                                    <ul>
                                        <li><a href="#" title="Facebook" data-tippy-placement="top"><i class="icon-brand-facebook"></i></a></li>
                                        <li><a href="#" title="LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div id="single-job-map-container">
                        <div id="singleListingMap" data-latitude="37.777842" data-longitude="-122.391805" data-map-icon="im im-icon-Hamburger"></div>
                        <a href="#" id="streetView">Street View</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">

                <section id="contact" class="margin-bottom-60">
                    <h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us!</h3>

                    <form method="post" name="contactform" action="{{ route('contact.store') }}" id="contactform" autocomplete="on">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-with-icon-left">
                                    <input class="with-border" name="name" type="text" id="name" placeholder="Your Name" required="required" />
                                    <i class="icon-material-outline-account-circle"></i>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-with-icon-left">
                                    <input class="with-border" name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
                                    <i class="icon-material-outline-email"></i>
                                </div>
                            </div>
                        </div>

                        <div class="input-with-icon-left">
                            <input class="with-border" name="subject" type="text" id="subject" placeholder="Subject" required="required" />
                            <i class="icon-material-outline-assignment"></i>
                        </div>

                        <div>
                            <textarea class="with-border" name="comments" cols="40" rows="5" id="comments" placeholder="Message" spellcheck="true" required="required"></textarea>
                        </div>

                        <input type="submit" class="submit button margin-top-15" id="submit" value="Submit Message" />

                    </form>
                </section>

            </div>

        </div>
    </div>
    <!-- Content / End -->

    @include('partials.footer')
</div>


<!-- Scripts
================================================== -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
<script src="{{ asset('js/infobox.min.js') }}"></script>
<script src="{{ asset('js/markerclusterer.js') }}"></script>
<script src="{{ asset('js/maps.js') }}"></script>
@if(auth()->check() && auth()->user()->hasRole('driver'))
    @include('scripts.capture-location')
@endif
</body>
</html>
