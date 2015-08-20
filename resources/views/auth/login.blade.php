<!-- resources/views/auth/login.blade.php -->

@extends('layouts.login')

@section('content')

<form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <div>
        <input type="text" name="username" value="{{ old('username') }}" placeholder="Nom d'utilisateur">
    </div>

    <div>
        <input type="password" name="password" id="password" placeholder="Mot de passe">
    </div>

    <div class="clearfix">
        <div class="left switch">
            <input id="rememberCheckboxSwitch" type="checkbox" name="remember">
            <label for="rememberCheckboxSwitch"></label>
        </div>

        <div class="left show-for-medium-up" style="margin-top: 5px; margin-left: 10px;">
            <span>Rester connecté</span>
        </div>

        <div class="right">
            <button type="submit" class="small-12 medium radius button">Connexion</button>
        </div>
    </div>
</form>

<hr style="margin-top:0px" />

<a href="google" class="small-12 medium radius alert button">Se connecter avec Gadz.org</a>

@endsection