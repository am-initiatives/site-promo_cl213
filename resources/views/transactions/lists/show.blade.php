{{-- Afficher une liste de buquages --}}
@extends('layouts.main', ['page_title' => 'Liste de buquages'])

@section('content')
<div class="panel">
	{{-- entête --}}
	<div>
		<h3>Compte crédité : <strong>{{ $list['credit']['account'] }}</strong></h3>
	</div>
	<div class="panel row">
		<div class="medium-1 columns">
			{!! Html::solde($list['amount']) !!}
		</div>
		<div class="medium-3 columns">
			<b>{{$list['wording']}}</b>
		</div>
		<div class="medium-7 columns radius progress success">
			<span class="meter" style="width: {{$list['acquited']/$list['total']*100}}%">
			</span>
		</div>
		<div class="medium-1 columns" style="text-align: center;">
			{{$list['acquited']}}/{{$list['total']}}
		</div>
	</div>
	{{-- liste des gens buqués --}}
	<table class="large-12">
	<caption>Comptes débités</caption>
	@foreach($list['debits'] as $transaction)
	<tr>
		<td class="medium-1" style="text-align:center">
		@if($transaction['state']=="pending")
			<i class="fa fa-times-circle fa-2" style="color:red"></i>
		@else
			<i class="fa fa-check-circle fa-2" style="color:green"></i>
		@endif
		</td>
		<td class="medium-5">
			{!!HTML::link(route("users.account.show",$transaction["account_id"]),$transaction["account"])!!}
		</td>
		<td class="medium-4">
			depuis le 
			{{$transaction["date"]}}
		</td>
		<td class="medium-2" style="text-align:right">
			{{-- Bouton Retirer une personne --}}
			@if(Auth::user()->isAllowed("destroy_buquage"))
			{!! Form::open(array('route' => 
				['transactions.destroy',$transaction['id']], 'method' => 'delete')) !!}
					<input type="submit" class="button tiny alert" style="margin:0" value="Retirer">
			{!! Form::close() !!}
			@endif
		</td>
	</tr>
	@endforeach
	</table>
	<ul class="button-group">
		{{-- Bouton ajouter quelqu'un --}}
		@if(Auth::user()->isAllowed("edit_buquage"))
		<li>
		{!! Form::open(array('route' => 
			['transactionlists.edit',$gpe], 'method' => 'get')) !!}
			<input type="submit" class="button tiny" value="Ajouter quelqu'un">
		{!! Form::close() !!}
		@endif
		</li>
		{{-- Bouton valider tout --}}
		@if(Auth::user()->isAllowed("edit_buquage"))
		<li>
		{!! Form::open(array('route' => 
			['transactionlists.acquit_all',$gpe], 'method' => 'put')) !!}
				<input type="submit" class="button tiny success" value="Valider tout">
		{!! Form::close() !!}
		</li>
		@endif
		{{-- Bouton supprimer tout --}}
		@if(Auth::user()->isAllowed("destroy_buquage_list"))
		<li>
		{!! Form::open(array('route' => 
			['transactionlists.destroy',$gpe], 'method' => 'delete')) !!}
				<input type="submit" class="button tiny alert" value="Supprimer tout">
		{!! Form::close() !!}
		</li>
		@endif
	</ul>
</div>


@endsection

@section('scripts')
@parent
<script type="text/javascript">
	$('select').select2();
</script>
@endsection
