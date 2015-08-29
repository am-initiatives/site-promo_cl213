<div id="map"></div>
<script type="text/javascript">
function initMap() {
    var france = new google.maps.LatLng(46.2157467, 2.2088258);

    var mapOptions = {
      zoom: 6,
      center: france
    }

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    setMarkers(map);
}

var users = {!! $positions or [] !!};

function setMarkers(map) {
    for (var i = 0; i < users.length; i++) {
        var user = users[i];
        var marker = new google.maps.Marker({
            position: {lat: user[1], lng: user[2]},
            map: map,
            title: user[0]
        });
    }
}


</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&callback=initMap"></script>