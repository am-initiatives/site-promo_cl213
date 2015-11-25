{{-- page des dernières opérations --}}
@extends('layouts.main', ['page_title' => 'Derniers buquages'])

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
					<td>
						<a href="{{ route('transactionlists.show', $transaction['group_id']) }}">
							<strong>{{ $transaction['wording'] }}</strong>
						</a>
					</td>
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