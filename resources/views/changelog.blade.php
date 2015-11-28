@extends('layouts.main', ['page_title' => 'Changelog'])

@section('content')

<div class="panel">
	<h3>V1.2.4</h3>

	<h4>Fonctionnalités</h4>

	<ul>
		<li>ajout du champ validation d'office pour l'ajout de personnes sur les listes de buquages</li>
	</ul>

	<h4>Résolutions de bugs</h4>

	<ul>
		<li>liste de buquage validée d'office validaient pas</li>
		<li>bouton valider tout marchait plus</li>
	</ul>
</div>

<div class="panel">
	<h3>V1.2.3</h3>

	<h4>Fonctionnalités</h4>

	<ul>
		<li>ajout de cette page</li>
	</ul>

	<h4>Résolutions de bugs</h4>

	<ul>
		<li>tri des comptes par solde</li>
		<li>bouton rechercher pour la carte marchait pas</li>
	</ul>

</div>

<div class="panel">
	<h3>V1.2.2</h3>
	<ul>
		<li>Première entrée</li>
	</ul>
</div>

@endsection