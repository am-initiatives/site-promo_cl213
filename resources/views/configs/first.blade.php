@extends('layouts.config', ['page_title' => 'Première connexion'])

@section('content')
<div class="main" id="moving-container">
	<div class="moving first-moving">
		<div class="banner">
			<h3>Première connexion !</h3>
		</div>
		<div class="container">
			<p class="small text-justify">
				C'est la première fois que tu te connectes sur le site. Suis les quelques étapes suivantes pour ne rien oublier !
			</p>
			<div>
				<input type="button" class="right button small info mover" value="Commencer">
			</div>
		</div>
	</div>
	<div class="moving">
		<div class="banner">
			<h3>Nouveau mot de passe</h3>
		</div>
		<div class="container">
			<p class="small text-justify">
				Tu devrais configurer un mot de passe pour accèder au site sans être connecté via Gadz.org.
			</p>
			{!! Form::open(array('route' => 'configs.first.password','id' => 'password_form')) !!}
				@include('auth.forms.new_password')
				<div>
					<input type="submit" name="save_password" class="right button small" value="Enregistrer">
					<input type="button" class="left button small info mover" value="Passer">
				</div>
			{!! Form::close() !!}
		</div>
	</div>
	<div class="moving">
		<div class="banner">
			<h3>Où es-tu en ce moment ?</h3>
		</div>
		<div class="container" style="max-width: 1080px;">
			<div style="height: 500px;">
				@include('includes.map', ['mapOptions' => ['search']])
			</div>
			{{-- <input type="submit" name="pac-input-button" class="right button small" value="Enregistrer"> --}}
		</div>
	</div>
	<div class="moving">
		<div class="banner">
			<h3>Zamer'sss !</h3>
		</div>
		<div class="container">
			<p class="small text-justify">
				C'est fini, toutes les informations nécessaires ont été enregistrées, tu peux maintenant profiter de ce TTG site !
			</p>
			<div class="text-center">
				<a href="{{ route('home') }}">
					<input type="button" class="button small" value="Accèder au site">
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
@parent
<script>
	$(document).ready(function() {
		$('.mover').click(function () {
			move($(this).parents(".moving").first());
		});

		$('#password_form').submit(function (e) {
			e.preventDefault();

			$.ajax({
				type: 'POST',
				cache: false,
				url: $(this).attr('action'),
				data: $(this).serialize(),
				context: this,
				success: function(data) {
					if (data == "OK") {
						move($(this).parents(".moving").first());
					}
				}
			});
		});

		$('#pac-input-button').click(function () {
			var location = window.markers[0].getPosition();

			$.ajax({
				method: "POST",
				cache: false,
				url: "{{ route('configs.first.location') }}",
				data: {
					location: [location.lat(), location.lng()]
				},
				context: $(this),
				success: function(data) {
					if (data == "OK") {
						move($(this).parents(".moving").first());
					}
				}
			});
		});
	});

	function move(object) {
		object.animate({
				left: '-50%'
			}, 500, function() {
				$(this).css('left', '150%');
				$(this).appendTo('#moving-container');
				$(this).hide();
			});

		object.next().show();
		object.next().animate({
				left: '50%'
			}, 500, function () {
				if($(this).find("#map").size()) {
					// Initialise au dernier moment
					initMap();
				}
			});
	}
</script>
@endsection