@extends('layouts.main', ['page_title' => $user->getTitle()])

@section('content')

<div class="panel">
@unless(isset($user))
	<p>Impossible de trouver cet utilisateur.</p>
@else
	<div class="row">
		<div class="medium-3 column">
			<img style="width: 200px;" src="{{ $user->getPictureLink() }}">
		</div>
		<div class="medium-9 column">
			<h3>{{ $user->getTitle() }}</h3>
			<table>
				<tr>
					<td>Nom :</td>
					<td><strong>{{ $user->last_name }}</strong></td>
				</tr>
				<tr>
					<td>Prénom :</td>
					<td><strong>{{ $user->first_name }}</strong></td>
				</tr>
				<tr>
					<td>Buque :</td>
					<td><strong>{{ $user->nickname }}</strong></td>
				</tr>
				<tr>
					<td>Téléphone :</td>
					<td><strong>{{ $user->phone }}</strong></td>
				</tr>
				<tr>
					<td>e-mail :</td>
					<td><strong>{{ $user->email }}</strong></td>
				</tr>
				<tr>
					<td>Position géographique :</td>
					<td><strong>{{ strtr($user->pos, ['"' => '']) }}</strong></td>
				</tr>
			</table>
		</div>
	</div>
@endunless
</div>

@endsection