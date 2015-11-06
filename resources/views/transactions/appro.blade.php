@extends('layouts.master')

@section('content')
<div class="panel">
	<h3>Approvisionner le compre de {!!$user->nickname!!}</h3>
	{!! Form::open(array('route' => ['transactions.appro.store',$user->id])) !!}

	<div class="row">
		<label>
			Intitulé<br>
			<i>(le buquage s'appelera "Appro &lt;intitulé&gt;")</i>
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