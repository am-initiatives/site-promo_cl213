<!-- resources/views/auth/login.blade.php -->

@extends('layouts.login', ['page_title' => 'Connexion'])

@section('content')

<form method="POST" action="{{ route('auth.signin') }}">
	{!! csrf_field() !!}

	<div>
		<input type="text" name="email" value="{{ old('email') }}" placeholder="Nom d'utilisateur">
	</div>

	<div>
		<input type="password" name="password" id="password" placeholder="Mot de passe">
	</div>

	<div class="clearfix">
		<div class="columns medium-7">
			<input type="checkbox" name="remember" id="remember"><label for="remember">Rester connecté</label>
			<br/>
			<a href="{{ route('password.email') }}">Mot de passe oublié</a>
		</div>

		<div class="columns medium-5 text-right">
			<button type="submit" class="medium radius button">Connexion</button>
		</div>
	</div>
</form>

<hr style="margin-top:0px" />

<a href="{{route('auth.google')}}" class="small-12 medium radius alert button">Se connecter avec Gadz.org</a>

@endsection
