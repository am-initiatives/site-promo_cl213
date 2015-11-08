@extends('layouts.master')

@section('styles')
@parent
<style type="text/css">
	body {
		background: url("{{ URL::to('login-background.jpg') }}") no-repeat bottom center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}

	#login-panel {
		box-shadow: 0px 0px 10px 0px rgba(50, 50, 50, 0.2);
	}
</style>
@endsection

@section('body')
<div class="row" style="padding-top: 10%">
	<div class="large-6 medium-8 large-offset-3 medium-offset-2 columns">
		<div id="login-panel" class="panel">
			<a id="login-hide" class="show-for-medium-up" style="display: block; text-align: right; margin-top: -18px; margin-right: -10px;">&times;</a>
			@yield('content')
		</div>
		@if (count($errors) > 0)
			<div class="panel">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
</div>
@endsection