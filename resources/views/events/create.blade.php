{{-- créer un évènement --}}
@extends('layouts.master')

@section('content')
<div class="panel">
{!! Form::open(array('route' => ['event.store'])) !!}
<label>Nom de l'évènement :
	{!! Form::text('name') !!}
</label>
<label>Description
	{!! Form::textArea("description") !!}
</label>

<div class="row" style="text-align:right">
{!! Form::submit('Créer', ['class' => 'small button']) !!}
</div>

{!!Form::close()!!}
</div>


@endsection

