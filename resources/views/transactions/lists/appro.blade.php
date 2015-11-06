@extends('layouts.master')

@section('content')

<div class="panel">
	<h3>Appros Multiples</h3>

	{!! Form::open(array('route' => ['transactionlist.appro.store'])) !!}
	<div class="row">
		<div class="medium-6 columns">
			<ul class="no-bullet">
			@foreach($creditables as $user)
				<li><label>
					{!! Form::checkBox('credited[]',$user->id) !!}
					{!! $user->getTitle() !!}
				</label></li>
			@endforeach
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="medium-9 columns">
			<label>Libellé
				{!! Form::text('wording') !!}
			</label>
		</div>
		<div class="medium-3 columns">
			<label>Montant à Chacun
				{!! Form::text('amount') !!}
			</label>
		</div>
	</div>
	<div class="row">
		<div class="columns">
			{!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
		</div>
	</div>
{!! Form::close() !!}
</div>

@endsection