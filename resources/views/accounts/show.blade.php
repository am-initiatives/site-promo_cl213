@extends('layouts.master')

@section('content')

<div class="panel">

<div class="row">
    <div class="large-10 columns">
        Solde du compte <strong>{!! Html::solde($solde / 100, '€') !!}</strong>
    </div>
    <div class="large-2 columns" style="text-align:right">
        <a href="{{ route('transactions.show', Auth::user()->id) }}" class="button tiny">Détails</a>
    </div>
</div>


<ul class="tabs" data-tab>
    <li class="tab-title active"><a href="#debits">Débits</a></li>
    <li class="tab-title"><a href="#credits">Crédits</a></li>
</ul>

<div class="tabs-content">
    <div class="content active" id="debits">
        @unless(count($debits))
        <p>Aucun débit pour le moment.</p>
        @else
        <table class="small-12">
            <thead>
                <th>Etat</th>
                <th>Date</th>
                <th>Libellé</th>
                <th>Émetteur/Récepteur</th>
                <th>Montant</th>
            </thead>
            <tbody>
                @foreach($debits as $transaction)
                    <tr>
                        <td style="text-align:center">
                        @if($transaction['state']=="pending")
                            <i class="fa fa-times-circle fa-2" style="color:red"></i>
                        @else
                            <i class="fa fa-check-circle fa-2" style="color:green"></i>
                        @endif
                        </td>
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
    <div class="content" id="credits">
        @unless(count($credits))
        <p>Aucun crédit pour le moment.</p>
        @else
        <ul class="accordion" data-accordion>
        @foreach($credits as $gpe => $credit)
            <li class="accordion-navigation">
                {{-- entête --}}
                <a href="#a{{$gpe}}" aria-expanded="false" class="row">
                    <div class="medium-1 columns">
                        {!! Html::solde($credit['amount'] / 100, '€') !!}
                    </div>
                    <div class="medium-2 columns">
                        <b>{{$credit["wording"]}}</b>
                    </div>
                    <div class="medium-2 columns radius progress success large-8">
                        <span class="meter" style="width: {{$credit['acquited']/$credit['total']*100}}%">
                        </span>
                    </div>
                    <div class="medium-1 columns" style="text-align: center;">
                        {{$credit['acquited']}}/{{$credit['total']}}
                    </div>
                </a>
                {{-- liste des gens buqués --}}
                <div id="a{{$gpe}}" class="content">
                    <table class="large-12">
                    @foreach($credit["rows"] as $transaction)
                    <tr>
                        <td class="medium-1" style="text-align:center">
                        @if($transaction['state']=="pending")
                            <i class="fa fa-times-circle fa-2" style="color:red"></i>
                        @else
                            <i class="fa fa-check-circle fa-2" style="color:green"></i>
                        @endif
                        </td>
                        <td class="medium-6">
                            {{$transaction["account"]}}
                        </td>
                        <td class="medium-5">
                            depuis le 
                            {{$transaction["date"]}}
                        </td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </li>
        @endforeach
        </ul>
        @endunless
    </div>
</div>

</div>

@endsection