<?php $positions = json_encode(App\User::getPositions()); ?>

@extends('layouts.master')

@section('content')
    <div class="panel">
        <div class="row">
            <a href="{{ route('tools.map.full') }}">Voir en plein écran</a>
        </div>
        <div class="row">
            <div class="small-12" style="height: 600px;">
                @include('google.map')
            </div>
        </div>
        <div class="row">
            <h4>Mettre à jour ma position</h4>
            <input type="text" name="address" id="address" placeholder="20 rue porte de Paris, Cluny">
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
        $(document).ready(function () {
            $('#address').keypress(function (e) {
                if (e.which == 13) {
                    getFromAdress(this.value);
                }
            });
        });
        </script>
        @parent
    @endsection
@endsection
