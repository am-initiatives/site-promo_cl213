@extends('layouts.main', ['page_title' => 'Accueil'])

@section('content')
	<div class="row">
		<div class="columns medium-4">
			<div>
				<a href="{{ route('users.account.show', $user->id) }}">
					<div class="panel text-center">
						Solde : {!! Html::solde($user->getBalance()) !!}<br>
						@if($user->debits()->pending()->count()!=0)
						A payer : {!! Html::solde(-$user->debits()->pending()->sum("amount")) !!}<br>
						@endif
						@if($user->credits()->pending()->count()!=0)
						A Recevoir : {!! Html::solde($user->credits()->pending()->sum("amount")) !!}
						@endif
					</div>
				</a>
			</div>
			<div class="show-for-medium-up">
				<a href="{{ route('map.show') }}">
					<div class="panel">
						<h5>Où sont mes prom'squets ?</h5>
						<img style="width: 100%;" src="{{ url('images/map.png') }}">
					</div>
				</a>
			</div>
			@foreach($events as $event)
			<div>
				<a href="{{route('event.show',$event->id)}}">
					<div class="panel">
						<div class="row">
							<div class="column small-4">
							{{$event->getTitle()}}
							</div>
							<div class="column small-8 radius progress success" style="margin:0">
							@if($event->credits()->count()!=0)
								<span class="meter" style="width: {{$event->credits()->acquited()->count()/$event->credits()->count()*100}}%">
								</span>
							@else
								<span class="meter" style="width: 100%">
								</span>
							@endif
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
		<div class="columns medium-8">
			@include('posts.show')
		</div>
	</div>
@endsection
