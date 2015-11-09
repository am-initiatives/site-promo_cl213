@extends('layouts.main')

@section('content')

<div class="panel">
	<div class="row">
		<div class="column medium-5">
			<div class="clearfix" style="position:relative">
			<img src="{{$event->getPictureLink()}}" style="top:0;bottom:0;height:200px">
			<h3 style="position:absolute;top:0;background-color:white;">{{$event->getTitle()}}</h3>
			</div>
			<div>
				Solde de l'évènement <strong>{!! Html::solde($event->getBalance()) !!}</strong>
			</div>
		</div>
		@if(Auth::user()->isAllowed("edit_event_".$event->id))
		<div class="column medium-7" style="text-align:right">
			<a href="{{ route('event.edit', $event->id) }}" class="button small">Editer</a>
		</div>
		@endif
	</div>
	<fieldset>
		<legend>Description</legend>
		<div class="row">{{$event->info}}</div>
	</fieldset>

</div>

<div class="panel">
	@include('users.accounts.bare_show',array_merge(
		$event->recap(),
		['solde' => $event->getBalance()])
	)
</div>
@endsection