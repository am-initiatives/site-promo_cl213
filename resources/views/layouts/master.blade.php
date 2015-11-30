<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, max-width=, initial-scale=1.0" />
		<title>CL213{{ isset($page_title) ? ' | ' . $page_title : '' }}</title>
		@section('styles')
		<link rel="stylesheet" href="{{ URL::to('foundation-5.5.3/css/foundation.css') }}" />
		<link rel="stylesheet" href="{{ URL::to('select2-foundation5.css') }}" />
		<link rel="stylesheet" href="{{ URL::to('font-awesome-4.4.0/css/font-awesome.min.css') }}">

		<link rel="stylesheet" href="{{ URL::to('template/master.css') }}" />
		@show
	</head>
		<body>

		@yield('body')

		@section('scripts')
		<script src="{{ URL::to('foundation-5.5.3/js/vendor/modernizr.js') }}"></script>
		<script src="{{ URL::to('foundation-5.5.3/js/vendor/jquery.js') }}"></script>
		<script src="{{ URL::to('foundation-5.5.3/js/foundation.min.js') }}"></script>
		
		<script src="{{ URL::to('select2-3.5.4/select2.min.js') }}"></script>

		<script>
			$(document).foundation();
		</script>
		@show

		<div style="position:fixed;bottom:0;right:10px;" class="show-for-medium-up">
			<h5>
				<small style="color:black;">
				@if(Auth::user())
					<a href="{{route('changelog')}}">
						@include("includes.version")
					</a>
				@else
					@include("includes.version")
				@endif
				</small>
			</h5>
		</div>
	</body>
</html>
