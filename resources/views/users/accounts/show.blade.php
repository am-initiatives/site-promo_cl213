{{-- Page de visualisation de l'état du compte --}}
@extends('layouts.main')

@section('content')

<div class="panel">

	<div class="row">
		<div class="large-5 columns">
			Solde du compte <strong>{!! Html::solde($solde / 100, '€') !!}</strong>
		</div>
		<div class="large-5 columns" style="text-align:right">
			<ul class="button-group">
				@if(Auth::user()->isAllowed("appro",null) && !$user->hasRole("event"))
				<li>
					<a href="{{ route('transactions.appro.create', $user->id) }}" class="button small success">Approvisionner</a>
				</li>
				@endif
				<li>
					<a href="{{ route('users.account.details', $user->id) }}" class="button small">Détails</a>
				</li>
			</ul>
		</div>
	</div>

	@include('users.accounts.bare_show')

</div>

@endsection