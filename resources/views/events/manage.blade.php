@extends('layouts.main', ['page_title' => 'Gestion de l\'event : '.$event->getTitle()])

@section('content')

<div class="panel">
	<h3>Gestion des droits</h3>

	{!!Form::open([
		'route' => ['event.update',$event->id],
		'method' => 'put'
	]) !!}

	<table>
		<tr>
			<th>Buque</th>
			<th>Admin</th>
			<th>Harpag's</th>
			<th>Rien</th>
		</tr>
		@foreach($pgs as $pg)
		<tr>
			<td>{!!$pg->getTitle()!!}</td>
			@if($pg->hasPermission("all"))
			<td><i class="fa fa-star"></i></td>
			<td><i class="fa fa-star"></i></td>
			<td><i class="fa fa-star"></i></td>
			@else
			<td>{!!Form::radio(
					'role['.$pg->id.']',
					'admin',
					$pg->hasRole("admin_event_".$event->id)
				)!!} 
			</td>
			<td>{!!Form::radio(
					'role['.$pg->id.']',
					'harpags',
					$pg->hasRole("edit_event_".$event->id)
				)!!}
			</td>
			<td>{!!Form::radio(
					'role['.$pg->id.']',
					'none',
					!$pg->hasRole("admin_event_".$event->id) 
					&& !$pg->hasRole("edit_event_".$event->id)
				)!!}
			</td>
			@endif
		</tr>
		@endforeach
	</table>

	{!! Form::submit("Mettre à jour",["class"=>"button small"]) !!}
	{!! Form::close() !!}
</div>

@endsection