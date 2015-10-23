{{-- liste des comptes --}}
@extends('layouts.master')

@section('content')

<div class="panel">
@unless(count($accounts))
    <p>Aucun compte n'est enregistré</p>
@else
    <table class="small-12">
        <caption>Liste des comptes</caption>
        <thead>
            <th>#</th>
            <th>Propriétaire</th>
            <th>Solde</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td><strong>{{ $account->getTitle() }}</strong></td>
                    <td style="text-align: right;">
                        {!! Html::solde($account->getBalance() / 100, '€') !!}
                    </td>
                    <td style="text-align: right; width: 50px;">
                        <a href="{{ route('accounts.show', $account->id) }}"><i class="fa fa-list"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endunless
</div>

@endsection