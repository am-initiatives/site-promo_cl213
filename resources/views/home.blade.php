@extends('layouts.master')

@section('content')
	<div class="row">
		<a href="{{ route('accounts.show', $user->account->id) }}">
			<div class="columns medium-4">
				<div class="panel" style="text-align: center;">
					Solde : {!! Html::solde($user->account->getBalance() / 100, '€') !!}
				</div>
			</div>
		</a>
		<a href="{{ route('users.show', $user->id) }}">
			<div class="columns medium-8">
				<div class="panel">
					<img style="width: 150px;" src="{{ $user->getPictureLink() }}">
				</div>
			</div>
		</a>
	</div>
	<div class="row">
		<div class="small-12" style="height: 600px;">
			@include('google.map')
		</div>
	</div>
@endsection