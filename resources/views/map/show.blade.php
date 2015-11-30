@extends('layouts.main', ['page_title' => 'Carte de Prom\'sss'])

@section('content')
<div class="panel" style="height:600px; padding: 0px;">
	@include('includes.map', ['mapOptions' => ['init', 'search']])
</div>
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
