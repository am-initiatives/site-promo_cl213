@extends('layouts.main', ['page_title' => $event->getTitle()])

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
		<div class="column medium-7 text-right">
		<ul class="button-group">
			@if(Auth::user()->isAllowed("update_event_".$event->id))
			<li><a href="{{ route('event.manage', $event->id) }}" class="button small success">Gérer les harpags</a></li>
			@endif
			@if(Auth::user()->isAllowed("edit_event_".$event->id))
			<li><a href="{{ route('event.edit', $event->id) }}" class="button small">Editer</a></li>
			@endif
			@if(Auth::user()->isAllowed("destroy_event_".$event->id))
			<li>
				{!! Form::open(array('route' => 
								['event.destroy',$event->id], 'method' => 'delete','style'=>"display:inline")) !!}
					<button type="submit" class="small alert">
						Supprimer
					</button>
				{!! Form::close() !!}
			</li>
			@endif
		</ul>
		</div>
	</div>
	<fieldset>
		<legend>Description</legend>
		<div class="row">{{$event->info}}</div>
	</fieldset>

</div>

<div class="panel">
	@include(
		'users.accounts.bare_show',array_merge(
			$event->recap(),
			['solde' => $event->getBalance()]
		)
	)
</div>
@endsection