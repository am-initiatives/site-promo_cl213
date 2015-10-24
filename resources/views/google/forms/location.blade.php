<h4>Mettre à jour ma position</h4>
<div>
	<label>Rechercher une adresse :
		<input type="text" name="address" id="address" placeholder="Ex: 20 rue porte de Paris, Cluny" style="margin-bottom: 5px;">
	</label>
</div>
<div id="place"></div>

@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function () {
	$('#address').keypress(function (e) {
		if (e.which == 13) {
			searchAddress(this.value);
		}
	});
});

function searchAddress(address) {
	geocoder.geocode({'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			window.results = results;

			if (typeof window.results != 'undefined' && window.results.length > 0) {
				showResults(window.results);

				selectAddress(0);

				$("#save_location").show();
			} else {
				$("#save_location").hide();
			}
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

function showResults(results) {
	$("#place").html("");

	for (var i = 0; i < Math.min(results.length, 5); i++) {
		var result = results[i];
		var placediv = '<a href="#" onClick="selectAddress('+i+');"><div class="alert-box secondary place">'+result["formatted_address"]+'</div></a>';
		$("#place").append(placediv);
	}
}

function selectAddress(i) {
	var geometry = window.results[i].geometry;

	setNewMarker(geometry);
	var pos = [geometry.location.lat(), geometry.location.lng()];

	$("input[name='location']").val('[' + pos + ']');
}
</script>
@endsection
