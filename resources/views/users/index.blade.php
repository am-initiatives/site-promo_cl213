@extends('layouts.main')

@section('content')

<div class="panel">
@unless(count($users))
	<p>Aucun utilisateur.</p>
@else
	<table class="small-12">
		<caption>Liste des utilisateurs</caption>
		<thead>
			<th></th>
			<th>Buque</th>
			<th>Nom, Prénom</th>
			<th>e-mail</th>
			<th>Tel</th>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>
					@if(Auth::user()->isAllowed("log_as"))
						<a href="{{route('auth.log_as',$user->id)}}">
							<i class="fa fa-sign-in"></i>
						</a>
					@endif
					{!! Html::userIcons($user) !!}
				</td>
				<td>{{ $user->nickname }}</td>
				<td>{{ $user->last_name }} {{ $user->first_name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->phone }}</td>
				<td></td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endunless
</div>

@endsection