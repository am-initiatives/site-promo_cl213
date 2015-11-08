<!-- resources/views/auth/ -->

@extends('layouts.logged_out')

@section('content')

<form method="POST" action="{{ route('password.reset.store') }}">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <input type="text" name="email" value="{{ old('email') }}" placeholder="Adresse email">
    </div>

    <div>
        <input type="password" name="password" placeholder="Nouveau mot de passe">
    </div>

    <div>
        <input type="password" name="password_confirmation" placeholder="Répeter le mot de passe">
    </div>

    <div class="text-right">
        <button type="submit" class="medium radius button" style="margin-bottom: 0px;">Enregistrer</button>
    </div>
</form>

@endsection
