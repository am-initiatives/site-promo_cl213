@extends('layouts.master')

@section('content')


@unless(count($transactions))
    <p>Aucune opération pour le moment.</p>
@else
	<h4>Dernières transactions :</h4>

    <table class="table table-striped">
        <thead>
            <th>Date</th>
            <th>Libellé</th>
            <th>Compte crédité</th>
            <th>Compte débité</th>
            <th>Montant</th>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['date'] }}</td>
                    <td><strong>{{ $transaction['wording'] }}</strong></td>
                    <td>{{ $transaction['credited'] }}</td>
                    <td>{{ $transaction['debited'] }}</td>
                    <td style="text-align: right;">{!! Html::solde($transaction['amount'] / 100, '€') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endunless


@endsection