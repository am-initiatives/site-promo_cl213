@extends('layouts.full', ['page_title' => 'Carte plein écran'])

@section('content')
@include('includes.map', ['mapOptions' => ['init', 'search']])
@endsection

@section('scripts')
@parent
<script type="text/javascript">
	$('#pac-input-button').click(function () {
		var location = window.markers[0].getPosition();

		$.ajax({
			method: "POST",
			cache: false,
			url: "{{ route('map.store-location') }}",
			data: {
				location: [location.lat(), location.lng()]
			},
			success: function(data) {
				alert(data);
			}
		});
	});
</script>
@endsection
