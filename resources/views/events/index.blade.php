{{-- liste des évènements référencés --}}
@extends('layouts.main')

@section('content')

<div class="panel">
	<div class="row" style="text-align:right">
		<ul class="button-group">
			@if(Auth::user()->isAllowed("create_event",null))
			<li>
				<a href="{{ route('event.create') }}" class="button small success">Créer un évènement</a>
			</li>
			@endif
		</ul>
	</div>
@unless(count($events))
	<p>Aucun évènement pour le moment.</p>
@else
	<table class="small-12">
		<caption>Dernières opérations</caption>
		<thead>
			<th>Date de création</th>
			<th>Libellé</th>
			<th>Dépenses</th>
			<th></th>
			<th>Cotiz</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($events as $event)
				<?php 
					$spendings = $event->spendings();
					$gains = $event->gains();
					if($spendings!= 0 && $spendings>$gains)
						$deficit = ($spendings-$gains)/($spendings)*100;
					else
						$deficit = 0;
				?>
				<tr>
					<td class="medium-2">{!! Html::diff($event->created_at) !!}</td>
					<td class="medium-2"><strong>{{ $event->getTitle() }}</strong></td>
					<td class="medium-1">{!! Html::solde($spendings) !!}</td>
					<td class="medium-5">
						<div class="progress">
							<span class="meter alert" style="width:{{$deficit}}%"></span>
							<span class="meter success" style="width:{{100-$deficit}}%"></span>
						</div>
					</td>
					<td class="medium-1">{!! Html::solde($gains) !!}</td>
					<td class="medium-1" style="text-align: right; width: 50px;">
						<a href="{{ route('event.show', $event->id) }}"><i class="fa fa-list"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endunless
</div>
@endsection