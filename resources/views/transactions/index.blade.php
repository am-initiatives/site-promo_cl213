@extends('layouts.master')

@section('content')

@unless(count($transactions))
    <p>Aucune opération pour le moment.</p>
@else
    <table class="small-12">
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
                    <td style="text-align: right;">{!! Html::solde($transaction['amount'] / 100, '€') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endunless


@endsection