<div id="map" style="height: 100%"></div>
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

	var locations = {!! $locations or "[]" !!};
	setMarkers(window.map, locations);
}


function setMarkers(map, locations) {
	for (var i = 0; i < locations.length; i++) {
		var location = locations[i];
		var marker = new google.maps.Marker({
			position: {lat: location[1], lng: location[2]},
			map: map,
			title: location[0],
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
@if(!isset($noInit))
<script async defer src="http://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&callback=initMap"></script>
@endif
@endsection
