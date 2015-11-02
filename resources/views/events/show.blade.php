@extends('layouts.master')

@section('content')

<div class="panel">
	<h3>{{$event->name}}</h3>
	<img src="{{$event->picture}}">
	<p>{{$event->description}}</p>
</div>

@endsection