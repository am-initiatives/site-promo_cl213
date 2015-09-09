@extends('layouts.master')

@section('content')

<div class="panel">
    <div class="row">
        <div class="columns medium-9">
            <label>Choisir des comptes
                {!! Form::select('accounts[]', $debitables, null, ['id'=>'accounts', 'multiple'=>'multiple']) !!}
            </label>
        </div>
        <div class="columns medium-3">
            <label>Montant
                {!! Form::text('amount', null, ['id' => 'amount']) !!}
            </label>
        </div>
        <div class="columns">
            {!! Form::button('Débiter', ['id' => 'debited-button', 'class' => 'button tiny']) !!}
            {!! Form::button('Créditer', ['id' => 'credited-button', 'class' => 'button tiny']) !!}
        </div>
    </div>
{!! Form::open(array('route' => ['transactions.store'])) !!}
    <div class="row">
        <div class="columns">
            <label>Libellé
                {!! Form::text('wording') !!}
            </label>
        </div>
    </div>
    <div id="tables" class="row">
    </div>

    <div class="row">
        <div class="columns">
            {!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
        </div>
    </div>
{!! Form::close() !!}
</div>


@endsection

@section('scripts')
@parent
<script type="text/javascript">
    $('select').select2();

    promo = {tables: {debited: {},credited: {}}};

    function addFields(table) {
        var values = $("#accounts").val();
        var amount = $("#amount").val();

        $.each(values, function (i, e) {
            promo.tables[table][e] = amount;
        });

        $.ajax({
            url: "{{ route('transactions.lists.tables') }}",
            data: promo.tables
        }).done(function (data) {
            $("#tables").html(data);
        });

        $("#accounts").val([]).change();
    }

    $(document).ready(function () {
        $("#debited-button").click(function () {
            addFields("debited");
        });
    });

    $(document).ready(function () {
        $("#credited-button").click(function () {
            addFields("credited");
        });
    });
</script>
@endsection
