@extends("layouts.master",["page_title"=>"Configuration"])

@section("styles")
	@parent
	<link rel="stylesheet" href="{{ URL::to('template/config.css') }}" />
@endsection

@section("body")
	@parent
	@yield('content')
@endsection