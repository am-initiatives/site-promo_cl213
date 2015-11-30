// Initialise la carte
function initMap() {
	geocoder = new google.maps.Geocoder();

	var france = new google.maps.LatLng(46.2157467, 2.2088258);

	var mapOptions = {
		zoom: 5,
		mapTypeControl: false,
		center: france
	}

	window.map = new google.maps.Map(document.getElementById("map"), mapOptions);


	// [RECHERCHE]

	// Create the search box and link it to the UI element.
	var input_text = document.getElementById('pac-input-text');
	var input_button = document.getElementById('pac-input-button');

	if (input_text) {
		var searchBox = new google.maps.places.SearchBox(input_text);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input_text);
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input_button);

		// Bias the SearchBox results towards current map's viewport.
		map.addListener('bounds_changed', function() {
			searchBox.setBounds(map.getBounds());
		});

		window.markers = [];
		// [START region_getplaces]

		// Listen for the event fired when the user selects a prediction and retrieve
		// more details for that place.
		searchBox.addListener('places_changed', function() {
			var places = searchBox.getPlaces();

			if (places.length == 0) {
				return;
			}

			// Clear out the old markers.
			window.markers.forEach(function(marker) {
				marker.setMap(null);
			});
			window.markers = [];

			// For each place, get the icon, name and location.
			var bounds = new google.maps.LatLngBounds();
			places.forEach(function(place) {

				// Create a marker for each place.
				window.markers.push(new google.maps.Marker({
					map: map,
					title: place.name,
					position: place.geometry.location
				}));

				if (place.geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
			});
			map.fitBounds(bounds);
		});

		// [END region_getplaces]
	};

	// [END RECHERCHE]

	// Affiche les marqueurs
	setMarkers(window.map, window.locations);
}

// Place des marqueurs sur la carte
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
