@extends('layouts.master')

@section('content')


@unless(isset($user))
    <p>Impossible de trouver cet utilisateur.</p>
@else
	<h3>Profil de {{ $user->nickname }}</h3>

    <ul>
        <li>Nom : <strong>{{ $user->last_name }}</strong></li>
        <li>Prénom : <strong>{{ $user->given_name }}</strong></li>
        <li>Buque : <strong>{{ $user->nickname }}</strong></li>
    </ul>
@endunless


@endsection