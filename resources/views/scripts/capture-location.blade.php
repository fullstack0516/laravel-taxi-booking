<script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.googleMapsAPIKey') }}&libraries=places"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function () {
            var geocoder = new google.maps.Geocoder();

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    let LatLng = new google.maps.LatLng(pos);

                    geocoder.geocode({'location': LatLng}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                $.ajax({
                                    url: '{{ route('locations.store') }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        address: results[0].formatted_address,
                                        latitude: position.coords.latitude,
                                        longitude: position.coords.longitude,
                                    },
                                    success: function (data) {
                                        // TODO
                                    },
                                    error: function (xhr, error) {
                                        console.log(error);
                                    }
                                });
                            } else {
                                window.alert('No results found');
                            }
                        }
                    });

                }, function() {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, map.getCenter());
            }

            function handleLocationError(browserHasGeolocation, pos) {
                if (browserHasGeolocation) {
                    window.alert('Error: The Geolocation service failed.');
                } else {
                    window.alert('Error: Your browser doesn\'t support geolocation.');
                }
            }
        }, 10000);
    })
</script>
