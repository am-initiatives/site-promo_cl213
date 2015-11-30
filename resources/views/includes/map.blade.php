<?php if (!isset($mapOptions)) { $mapOptions = ['init']; } ?>
<div id="map-container" style="height:100%;">
	<div id="map" style="height: 100%"></div>
@if(in_array('search', $mapOptions))
	<input id="pac-input-text" class="controls" type="text" placeholder="Recherche ma position">
	<input id="pac-input-button" type="button" class="button tiny" value="Enregistrer ma position">
@endif
</div>

@section('scripts')
	@parent
<script type="text/javascript">
	window.locations = {!! $locations or "[]" !!};
</script>
<script src="{{ URL::to('template/map.js') }}"></script>
	@if(in_array('init', $mapOptions))
<script async defer src="http://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&libraries=places&callback=initMap"></script>
	@else
<script async defer src="http://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&libraries=places"></script>
	@endif
@endsection

@section('styles')
	@parent
<style type="text/css">
	.controls {
		margin-top: 10px;
		border: 1px solid transparent;
		border-radius: 2px 0 0 2px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		height: 32px;
		outline: none;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
	}

	#pac-input-text {
		background-color: #fff;
		font-family: Roboto;
		font-size: 15px;
		font-weight: 300;
		margin-top: 10px;
		margin-left: 12px;
		padding: 0 11px 0 13px;
		text-overflow: ellipsis;
		width: 300px;
	}

	#pac-input-button {
		margin-top: 10px;
		margin-right: 12px;
	}

	#pac-input-text:focus {
		border-color: #4d90fe;
	}

	.pac-container {
		font-family: Roboto;
	}

	#type-selector {
		color: #fff;
		background-color: #4d90fe;
		padding: 5px 11px 0px 11px;
	}

	#type-selector label {
		font-family: Roboto;
		font-size: 13px;
		font-weight: 300;
	}
</style>
@endsection