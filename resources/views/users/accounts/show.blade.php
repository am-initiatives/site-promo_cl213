{{-- Page de visualisation de l'état du compte --}}
@extends('layouts.main', ['page_title' => 'Compte de ' . $user->getTitle()])

@section('content')

<div class="panel">

	<div class="row">
		<div class="large-5 columns">
			<h3>{{$user->getTitle()}}</h3>
			Solde du compte <strong>{!! Html::solde($solde) !!}</strong>
		</div>
		<div class="large-5 columns text-right">
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