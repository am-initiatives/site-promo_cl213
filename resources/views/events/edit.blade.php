{{-- Avertis la personne qu'elle est logguée en tant que l'event --}}
@extends('layouts.main', ['page_title' => 'Connecté en tant qu'évènement])

@section('content')

<div class="panel">
	<div class="alert-box alert">
		Attention, tu es actuellement loggué avec le compte de l'évènement.
	</div>

	<p>
		Tout ce que tu fais à partir de maintenant sera fait en son nom.
	</p>
	<p>
		Pour revenir à ton compte initial, il suffit de déconnecter.
	</p>
</div>

@endsection