@extends('layouts.master')

@section('content')
	<div class="row" style="margin-top: 15px">
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
@endsection