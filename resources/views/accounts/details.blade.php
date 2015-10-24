@extends('layouts.master')

@section('content')

<div class="panel">
<p>Le solde de ce compte est de <strong>{!! Html::solde($solde / 100, '€') !!}</strong></p>
@unless(count($transactions))
	<p>Aucune opération sur ce compte pour le moment.</p>
@else
	<table class="small-12">
		<caption>Résumé du compte</caption>
		<thead>
			<th>Date</th>
			<th>Libellé</th>
			<th>Émetteur/Récepteur</th>
			<th>Montant</th>
		</thead>
		<tbody>
			@foreach($transactions as $transaction)
				<tr>
					<td>{{ $transaction['date'] }}</td>
					<td><strong>{{ $transaction['wording'] }}</strong></td>
					<td>{{ $transaction['account'] }}</td>
					<td style="text-align: right;">{!! Html::solde($transaction['amount'] / 100, '€') !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endunless
</div>

@endsection