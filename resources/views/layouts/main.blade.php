@extends('layouts.master')

@section('styles')
@parent
	@if(App::make("impersonator")->isImpersonating())
		<style type="text/css">body {background-color: yellow;}</style>
	@endif
@endsection

@section('body')
<div id="header">
	@include('includes.topbar')
</div>

<div class="container">
	<div id="content">
		@if($errors->count())
		<div data-alert class="alert-box info" style="margin: 10px;">
			{!! implode($errors->all(), '<br/>') !!}
			<a href="#" class="close">&times;</a>
		</div>
		@endif

		@yield('content')
	</div>
</div>

<div style="position:absolute;bottom:0;right:10px;">
	<h5><small>Site de prom's v1.2 usiné avec amoür par G109 et T154</small></h5>
</div>

@endsection
