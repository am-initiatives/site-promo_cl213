@extends('layouts.config')

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
				Tu devrais configurer un mot de passe pour pouvoir aussi accèder au site quand tu n'es pas connecté avec Gadz.org :
			</p>
			{!! Form::open(array('route' => 'configs.first.password','id' => 'password_form')) !!}
				@include('auth.forms.new_password')
				<div>
					<input type="button" class="left button small info mover" value="Passer">
					<input type="submit" name="save_password" class="right button small" value="Enregistrer">
				</div>
			{!! Form::close() !!}
		</div>
	</div>
	<div class="moving">
		<div class="banner">
			<h3>Où es-tu en ce moment ?</h3>
		</div>
		<div class="container" style="max-width: 1080px;">
			<div class="columns medium-8" style="height:500px; margin-bottom: 20px;">
				@include('google.map', ['noInit' => true])
			</div>
			<div class="columns medium-4">
				@include('google.forms.location')
			</div>
			<div class="columns small-12">
			{!! Form::open(array('route' => 'configs.first.location','id' => 'location_form')) !!}
				<input type="hidden" name="location">
				<input type="button" class="left button small info mover" value="Passer">
				<input type="submit" name="save_location" class="right button small" value="Enregistrer">
			{!! Form::close() !!}
			</div>
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
<script>
	$(document).ready(function() {
		$('.mover').click(function () {
			move($(this).parents(".moving").first());
		});

		$('#password_form, #location_form').submit(function (e) {
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
					$("body").append("\<script async defer src=\"http://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&callback=initMap\"\>\</script\>");
				}
			});
	}
</script>
@endsection