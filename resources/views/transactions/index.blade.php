{{-- page des dernières opérations --}}
@extends('layouts.main')

@section('content')

<div class="panel">
@unless(count($transactions))
	<p>Aucune opération pour le moment.</p>
@else
	<table class="small-12 sortable">
		<caption>Dernières opérations</caption>
		<thead>
			<th>Date</th>
			<th>Libellé</th>
			<th>Compte débité</th>
			<th>Compte crédité</th>
			<th>Montant</th>
		</thead>
		<tbody>
			@foreach($transactions as $transaction)
				<tr>
					<td>{{ $transaction['date'] }}</td>
					<td><strong>{{ $transaction['wording'] }}</strong></td>
					<td>{{ $transaction['debited'] }}</td>
					<td>{{ $transaction['credited'] }}</td>
					<td calss="text-right">{!! Html::solde($transaction['amount']) !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endunless
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