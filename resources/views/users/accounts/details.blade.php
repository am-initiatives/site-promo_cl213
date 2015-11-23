@extends('layouts.main')

@section('content')

<div class="panel">
	<h3>{{$user->getTitle()}}</h3>
	<p>Le solde de ce compte est de <strong>{!! Html::solde($user->getBalance()) !!}</strong></p>
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
					<td class="text-right">{!! Html::solde($transaction['amount']) !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endunless
</div>

@endsection