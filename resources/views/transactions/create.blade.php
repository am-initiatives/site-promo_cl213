@extends('layouts.main')

@section('content')
<div class="panel">

	<ul class="tabs" data-tab>
		<li class="tab-title active"><a href="#panel1">Normal</a></li>
		<li class="tab-title"><a href="#panel2">Forfait</a></li>
		<!-- <li class="tab-title"><a href="#panel3">Somme à diviser</a></li> -->
	</ul>
	<div class="tabs-content">

		<!-- Normal -->
		<div class="content active" id="panel1">
			{!! Form::open(array('route' => ['transactions.store'])) !!}
				<div class="row">
					<div class="medium-6 columns">
						<label>Compte à débiter
							{!! Form::select('debited_user_id', $debitables) !!}
						</label>
					</div>
				</div>
				<div class="row">
					<div class="medium-9 columns">
						<label>Libellé
							{!! Form::text('wording') !!}
						</label>
					</div>
					<div class="medium-3 columns">
						<label>Montant
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
	
		<!-- Forfait -->
		<div class="content" id="panel2">
			@include("transactions.lists.create");
		</div>

		<!-- Somme à diviser -->
		<!-- <div class="content" id="panel3">
			
		</div> -->
	</div>
</div>


@endsection

@section('scripts')
@parent
<script type="text/javascript">
	$('select').select2();
</script>
<script src="{{ URL::to('tablesorter-2.0/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() 
	    { 
	        $(".sortable").tablesorter(); 
	    } 
	); 
</script>
@endsection
