{{-- liste des comptes --}}
@extends('layouts.main')

@section('content')

<div class="panel">
@unless(count($accounts))
	<p>Aucun compte n'est enregistré</p>
@else
	<table class="small-12 sortable">
		<caption>Liste des comptes</caption>
		<thead>
			<th></th>
			<th>Propriétaire</th>
			<th>Dernière connexion</th>
			<th>Solde</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($accounts as $account)
				<tr>
					<td>{!! Html::userIcons($account) !!}</td>
					<td><strong>{{ $account->getTitle() }}</strong></td>
					<td>{!! Html::diff($account->connected_at) !!}</td>
					<td style="text-align: right;">
						{!! Html::solde($account->getBalance()) !!}
					</td>
					<td style="text-align: right; width: 50px;">
						<a href="{{ route('users.account.show', $account->id) }}"><i class="fa fa-list"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endunless
</div>

@endsection

@section('scripts')
@parent
<script src="{{ URL::to('tablesorter-2.0/jquery.tablesorter.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() 
	    { 
	        $(".sortable").tablesorter(); 
	    } 
	); 
</script>
@endsection
