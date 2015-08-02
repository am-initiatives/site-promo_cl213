@extends('layouts.master')

@section('content')

{!! Form::open(array('route' => ['transfers.store'])) !!}
    <div class="row">
        <div class="small-6 columns">
            <label>Compte à débiter
                {!! Form::select('size', $debitables) !!}
            </label>
        </div>
        <div class="small-6 columns">
            <label>Compte à créditer
                {!! Form::select('size', $creditables) !!}
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-7 columns">
            <label>Libellé
                {!! Form::text('wording') !!}
            </label>
        </div>
        <div class="small-3 columns">
            <label>Montant
                {!! Form::text('amount') !!}
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-3 columns">
            {!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
        </div>
    </div>
{!! Form::close() !!}



@endsection