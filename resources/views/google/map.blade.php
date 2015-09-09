<div id="map"></div>
@section('scripts')
@parent
<script type="text/javascript">

function initMap() {
    geocoder = new google.maps.Geocoder();

    var france = new google.maps.LatLng(46.2157467, 2.2088258);

    var mapOptions = {
      zoom: 5,
      center: france
    }

    window.map = new google.maps.Map(document.getElementById("map"), mapOptions);

    setMarkers(window.map);
}

var users = {!! $positions or "[]" !!};

function setMarkers(map) {
    for (var i = 0; i < users.length; i++) {
        var user = users[i];
        var marker = new google.maps.Marker({
            position: {lat: user[1], lng: user[2]},
            map: map,
            title: user[0],
            animation: google.maps.Animation.DROP
        });
    }
}


function setNewMarker(geometry) {
    if (typeof window.marker != 'undefined') {
        window.marker.setMap(null);
    }

    window.marker = new google.maps.Marker({
        position: geometry.location,
        map: window.map,
        title: "Ma position",
        animation: google.maps.Animation.DROP
    });

    if (typeof geometry.viewport != 'undefined') {
        window.map.fitBounds(geometry.viewport);
    } else {
        window.map.panTo(geometry.location);
        window.map.setZoom(16);
    }
}

</script>
<script async defer src="http://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&callback=initMap"></script>
@endsection
