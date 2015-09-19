<script type="text/javascript">
$(document).ready(function () {
    $('#address').keypress(function (e) {
        if (e.which == 13) {
            searchAddress(this.value);
        }
    });

    $('#savelocation').click(function () {
        var location = window.marker.getPosition();

        postNewLocation(location);
    });
});

function searchAddress(address) {
    geocoder.geocode({'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            window.results = results;

            console.log(results);

            if (typeof window.results != 'undefined' && window.results.length > 0) {
                showResults(window.results);

                selectAddress(0);

                $("#savelocation").show();
            } else {
                $("#savelocation").hide();
            }
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}


function searchAddress2(address) {
    $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        data: {
            key:"{{ env('API_KEY2') }}",
            address:address
        }
    }).done(function(data) {
        window.results = data["results"];

        if (typeof window.results != 'undefined' && window.results.length > 0) {
            showResults(window.results);

            selectAddress(0);

            $("#savelocation").show();
        } else {
            $("#savelocation").hide();
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
}

function postNewLocation(location) {
    $.ajax({
        method: "POST",
        url: "{{ route('tools.map.store-location') }}",
        data: {
            location: [location.lat(), location.lng()]
        }
    }).done(function(data) {
        alert(data);
    });
}
</script>
