<div id="map"></div>
<script type="text/javascript">

function initMap() {
    var france = new google.maps.LatLng(46.2157467, 2.2088258);

    var mapOptions = {
      zoom: 6,
      center: france
    }

    window.map = new google.maps.Map(document.getElementById("map"), mapOptions);

    setMarkers(window.map);
}

var users = {!! $positions or [] !!};

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

function getFromAdress(address) {
    $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        context: document.body,
        data: {
            key:"{{ env('API_KEY') }}",
            address:address
        }
    }).done(function(data) {
        if (typeof window.marker != 'undefined') {
            window.marker.setMap(null);
        }

        var location = data["results"][0]["geometry"]["location"];
        var bounds = data["results"][0]["geometry"]["bounds"];

        if (typeof bounds != 'undefined') {
            var northeast = new google.maps.LatLng(bounds["northeast"]["lat"],bounds["northeast"]["lng"]);
            var southwest = new google.maps.LatLng(bounds["southwest"]["lat"],bounds["southwest"]["lng"]);
            var formatBounds = new google.maps.LatLngBounds(southwest, northeast);
            window.map.fitBounds(formatBounds);
        } else {
            window.map.panTo(location);
            window.map.setZoom(16);
        }

        window.marker = new google.maps.Marker({
            position: location,
            map: window.map,
            title: "Ma position",
            animation: google.maps.Animation.DROP
        });

        //alert(window.marker.position.toString());
    });
}


</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&callback=initMap"></script>