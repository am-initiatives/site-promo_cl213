<div id="map"></div>
@section('scripts')
@parent
<script type="text/javascript">

function initMap() {
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


function setNewMarker(location, bounds) {
    if (typeof window.marker != 'undefined') {
        window.marker.setMap(null);
    }

    window.marker = setMarker({
        position: location,
        map: window.map,
        title: "Ma position",
        animation: google.maps.Animation.DROP
    });

    if (typeof bounds != 'undefined') {
        window.map.fitBounds(toBounds(bounds));
    } else {
        window.map.panTo(location);
        window.map.setZoom(16);
    }
}


function setMarker(data) {
    return new google.maps.Marker(data);
}


function toLocation(location) {
    return new google.maps.LatLng(location["lat"],location["lng"]);
}

function toBounds(bounds) {
    var ne = toLocation(bounds["northeast"]) ;
    var sw = toLocation(bounds["southwest"]) ;
    return new google.maps.LatLngBounds(sw, ne);
}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&callback=initMap"></script>
@endsection
