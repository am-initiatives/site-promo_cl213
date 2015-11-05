@extends('layouts.master')

@section('content')

<div class="panel">
	<div class="row">
		<div class="column medium-5">
			<h3>{{$event->getTitle()}}</h3>
			<div>
				Solde de l'évènement <strong>{!! Html::solde($event->getBalance() / 100, '€') !!}</strong>
			</div>
		</div>
		<div class="column medium-7" style="text-align:right">
			<a href="{{ route('event.edit', $event->id) }}" class="button small">Editer</a>
		</div>
	</div>
	<img src="{{$event->getPictureLink()}}">
	<p>{{$event->info}}</p>

</div>

<div class="panel">
	@include('users.accounts.bare_show',array_merge(
		$event->recap(),
		['solde' => $event->getBalance()])
	)
</div>
@endsection