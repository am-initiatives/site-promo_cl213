<?php $positions = json_encode(App\User::getPositions()); ?>

@extends('layouts.master')

@section('content')
	<div class="row">
		<a href="{{ route('tools.map.full') }}">Voir en plein écran</a>
	</div>
	<div class="row">
		<div class="small-12" style="height: 600px;">
			@include('google.map')
		</div>
	</div>
@endsection