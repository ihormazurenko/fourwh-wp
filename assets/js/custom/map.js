jQuery(document).ready(function($) {
    (function($) {
        var mapEl = document.getElementById('map');

        if (mapEl) {
            function initMap() {
                var map = new google.maps.Map(mapEl, {
                    zoom: 4,
                    center: {lat: 37.6979, lng: -97.314},
                    disableDefaultUI: true
                });

                setMarkers(map);
            }

            var beaches = [
                ['San Francisco', '24335 Prielipp Road, # 124<br> Wildomar, CA 92595<br> Phone: 800-511-4159', 37.773972, -122.431297],
                ['Los Angeles', '24335 Prielipp Road, # 124<br> Wildomar, CA 92595<br> Phone: 800-511-4159', 34.0522342, -118.2436849],
                ['Las Vegas', '24335 Prielipp Road, # 124<br> Wildomar, CA 92595<br> Phone: 800-511-4159', 36.114647, -115.172813],
                ['Chicago', '24335 Prielipp Road, # 124<br> Wildomar, CA 92595<br> Phone: 800-511-4159', 41.881832, -87.623177]
            ];

            function setMarkers(map) {
                // Adds markers to the map.
                var image = {
                    url: 'img/marker.png',
                    size: new google.maps.Size(28, 37),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(14, 37)
                };

                var shape = {
                    coords: [15, 36, 21, 25, 27, 20, 27, 8, 21, 4, 13, 1, 7, 2, 2, 9, 1, 17, 4, 22],
                    type: 'poly'
                };

                for (var i = 0; i < beaches.length; i++) {
                    var beach = beaches[i];
                    var marker = new google.maps.Marker({
                        position: {lat: beach[2], lng: beach[3]},
                        map: map,
                        icon: image,
                        shape: shape,
                        title: beach[0]
                    });

                    var infowindow = new google.maps.InfoWindow({});

                    google.maps.event.addListener(marker, 'click', (function (marker, beach) {
                        return function () {
                            infowindow.setContent('<div class="service-marker-box">' +
                                '                           <h2 class="service-marker-title">' + beach[0] + '</h2>' +
                                '<div class="service-marker-info">' + beach[1] + '</div>' +
                                '</div>');
                            infowindow.open(map, marker);
                        }
                    })(marker, beach));
                }
            }

            initMap();
        }
    })(jQuery);
});


