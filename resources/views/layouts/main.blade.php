@extends('layouts.master')

@section('styles')
@parent

	<link rel="stylesheet" href="{{ URL::to('template/tablesorter.css') }}" />

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
