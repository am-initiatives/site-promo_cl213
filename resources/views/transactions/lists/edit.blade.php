{{-- Ajout de gens à la liste de buquages --}}
@extends('layouts.main', ['page_title' => 'Ajouter des participants'])

@section('content')
<div class="panel">
		<h3>Ajouter des personnes à la liste de buquage</h3>
		<!-- Forfait -->
		<fieldset>
			<legend>{!! $wording !!} - {!! Html::solde($amount) !!}</legend>
			{!! Form::open(array('route' => ['transactionlists.update',$group_id],'method'=>'put')) !!}
				<div class="row">
					<div class="medium-6 columns">
						<ul class="no-bullet">
						@foreach($debitables as $idx => $name)
							<li><label>
								{!! Form::checkBox('debited[]',$idx) !!}
								{!! $name !!}
							</label></li>
						@endforeach
						</ul>
					</div>
				</div>
				@if($user->isAllowed("force_buquage"))
				<div class="row">
					<div class="column">
						<label>
							{!! Form::checkBox("force",1,true)!!}
							Buquage validé d'office
						</label>
					</div>
				</div>
				@endif
				<div class="row">
					<div class="columns">
						{!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
					</div>
				</div>
			{!! Form::close() !!}
	</fieldset>
</div>


@endsection

@section('scripts')
@parent
<script type="text/javascript">
	$('select').select2();
</script>
@endsection
