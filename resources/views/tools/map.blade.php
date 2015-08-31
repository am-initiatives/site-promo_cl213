<?php $positions = json_encode(App\User::getPositions()); ?>

@extends('layouts.master')

@section('content')
    <div class="panel">
        <div class="row">
            <a href="{{ route('tools.map.full') }}">Voir en plein écran</a>
             ou 
            <a href="{{ route('tools.map.location') }}">Mettre à jour ma position</a>
        </div>
        <div class="row">
            <div class="columns medium-12" style="height: 600px;">
                @include('google.map')
            </div>
        </div>
    </div>
@endsection