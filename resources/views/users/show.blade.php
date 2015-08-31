@extends('layouts.master')

@section('content')

<div class="panel">
@unless(isset($user))
    <p>Impossible de trouver cet utilisateur.</p>
@else
	<div class="row">
		<div class="medium-3 column">
			<img style="width: 200px;" src="{{ $user->getPictureLink() }}">
		</div>
		<div class="medium-9 column">
			<h3>{{ $user->getTitle() }}</h3>
			<ul>
			    <li>Nom : <strong>{{ $user->last_name }}</strong></li>
			    <li>Prénom : <strong>{{ $user->first_name }}</strong></li>
			    <li>Buque : <strong>{{ $user->nickname }}</strong></li>
			</ul>
		</div>
	</div>
@endunless
</div>

@endsection