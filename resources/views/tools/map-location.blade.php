@extends('layouts.main', ['page_title' => 'Mettre à jour ma position'])

@section('content')
	<div class="panel">
		<div class="row">
			<div class="columns medium-8" style="height: 600px;">
				@include('google.map')
			</div>
			<div class="columns medium-4">
				@include('google.forms.location')
				{!! Form::open(array('route' => 'tools.map.store-location','id' => 'location_form')) !!}
					<input type="hidden" name="location">
					<input type="submit" id="save_location" class="button small small-12" style="display: none;" value="Enregistrer">
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function () {
	$('#location_form').submit(function (e) {
		e.preventDefault();

		$.ajax({
			type: 'POST',
			cache: false,
			url: $(this).attr('action'),
			data: $(this).serialize(),
			context: this,
			success: function(data) {
				alert(data);
			}
		});
	});
});
</script>

@endsection
