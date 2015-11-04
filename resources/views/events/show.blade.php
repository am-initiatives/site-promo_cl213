@extends('layouts.master')

@section('content')

<div class="panel">
	<div class="row">
		<div class="column medium-5">
			<h3>{{$event->name}}</h3>
			<div>
				Solde de l'évènement <strong>{!! Html::solde($event->account->getBalance() / 100, '€') !!}</strong>
			</div>
		</div>
		<div class="column medium-7" style="text-align:right">
			<ul class="button-group">
				<li>
					<a href="{{ route('transactions.appro.create', $user->id) }}" class="button small alert">Déclarer une dépense</a>
				</li>
				<li>
					<a href="{{ route('users.account.details', $user->id) }}" class="button small success">Faire un Buquage</a>
				</li>
				<li>
					<a href="{{ route('users.account.details', $user->id) }}" class="button small">Editer</a>
				</li>
			</ul>
		</div>
	</div>
	<img src="{{$event->picture}}">
	<p>{{$event->description}}</p>

</div>

<div class="panel">
	@include('users.accounts.bare_show',array_merge(
		$event->account->recap(),
		['solde' => $event->account->getBalance()])
	)
</div>
@endsection