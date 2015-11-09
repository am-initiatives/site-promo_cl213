@extends('layouts.main')

@section('content')
	<div class="row">
		<div class="columns medium-4">
			<div>
				<a href="{{ route('users.account.show', $user->id) }}">
					<div class="panel" style="text-align: center;">
						Solde : {!! Html::solde($user->getBalance()) !!}<br>
						A payer : {!! Html::solde(-$user->debits()->pending()->sum("amount")) !!}<br>
						A Recevoir : {!! Html::solde($user->credits()->pending()->sum("amount")) !!}
					</div>
				</a>
			</div>
			<div class="show-for-medium-up">
				<a href="{{ route('tools.map') }}">
					<div class="panel">
						<h5>Où sont mes prom'squets ?</h5>
						<img style="width: 100%;" src="{{ url('images/map.png') }}">
					</div>
				</a>
			</div>
		</div>
		<div class="columns medium-8">
			@include('posts.show')
		</div>
	</div>
@endsection
