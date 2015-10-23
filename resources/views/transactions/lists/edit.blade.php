{{-- Ajout de gens à la liste de buquages --}}
@extends('layouts.master')

@section('content')
<div class="panel">
		<h3>Ajouter des personnes à la liste de buquage</h3>
        <!-- Forfait -->
        <fieldset>
        	<legend>{!! $wording !!} - {!! Html::solde($amount / 100, '€') !!}</legend>
            {!! Form::open(array('route' => ['transactionlist.update',$group_id],'method'=>'patch')) !!}
                <div class="row">
                    <div class="medium-6 columns">
                        <ul class="no-bullet">
                        @foreach($debitables as $idx => $name)
                            <li><label>
                                {!! Form::checkBox('debited[]',$idx) !!}
                                {!! $name !!}
                            </label></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="columns">
                        {!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
    </fieldset>
</div>


@endsection

@section('scripts')
@parent
<script type="text/javascript">
    $('select').select2();
</script>
@endsection
