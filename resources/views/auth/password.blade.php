<!-- resources/views/auth/password.blade.php -->

@extends('layouts.logged_out')

@section('content')

<form method="POST" action="{{ route('password.email.store') }}">
    {!! csrf_field() !!}

    @if(is_null(Session::get('status')))
    <div>
        <p>Renseigne ici ton adresse email <strong>gadz.org</strong>.<br/>
        Tu recevras ensuite un mail avec un lien pour choisir un nouveau mot de passe.</p>
    </div>
    @else
    <div>
        <p>{{ Session::get('status') }}</p>
    </div>
    @endif

    <hr style="margin-top:0px" />

    <div>
        <input type="text" name="email" value="{{ old('email') }}" placeholder="Adresse email">
    </div>

    <div class="text-right">
        <button type="submit" class="medium radius button" style="margin-bottom: 0px;">Envoyer</button>
    </div>
</form>

@endsection
