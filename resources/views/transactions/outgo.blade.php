@extends('layouts.master')

@section('content')
<div class="panel">
	<h3>Déclarer une dépense de votre part</h3>
	{!! Form::open(array('route' => ['transactions.outgo.store'])) !!}
	<div class="row">
		<label>
			Intitulé
			{!! Form::text("wording") !!}
		</label>
	</div>
	<div class="row">
		<label>Montant
			{!! Form::text('amount') !!}
		</label>

		<div class="columns">
			{!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
		</div>
	</div>

	{!! Form::close() !!}
</div>
@endsection

@section('scripts')
@parent
@endsection