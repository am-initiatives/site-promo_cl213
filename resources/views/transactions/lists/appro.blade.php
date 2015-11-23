@extends('layouts.main')

@section('content')

<div class="panel">
	<h3>Appros Multiples</h3>

	{!! Form::open(array('route' => ['transactionlist.appro.store'])) !!}
	<div class="row">
		<div class="medium-7 columns">
			<label>Libellé
				{!! Form::text('wording') !!}
			</label>
		</div>
		<div class="medium-3 columns">
			<label>Montant à Chacun
				{!! Form::text('amount') !!}
			</label>
		</div>
		<div class="medium-2 columns">
			{!! Form::submit('Enregister', ['class' => 'small radius button right']) !!}
		</div>
	</div>
	<div class="row">
		<div class="medium-12 columns">
			<table class="small-12 sortable">
				<thead>
					<th></th>
					<th>Buque</th>
					<th>Fam'sss</th>
					<th>NOM Prénom</th>
				</thead>
				<tbody>
				@foreach($creditables as $user)
					<tr>
						<td>
							{!! Form::checkBox('credited[]',$user->id, null, ['style'=>'margin: 0px;']) !!}
						</td>
						<td>
							{!! preg_replace('# [-&\d]+#', '', $user->getTitle(), 1) !!}
						</td>
						<td>
							{!! preg_replace('#.* (?=[-&\d]+)#', '', $user->getTitle(), 1) !!}
						</td>
						<td>
							{{ $user->last_name }} {{ $user->first_name }}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
{!! Form::close() !!}
</div>

@endsection

@section('scripts')
@parent
<script src="{{ URL::to('tablesorter-2.0/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() 
	    { 
	        $(".sortable").tablesorter(); 
	    } 
	); 
</script>
@endsection