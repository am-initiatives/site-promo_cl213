<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, max-width=, initial-scale=1.0" />
		<title>CL213 | {{ $page_title or "Accueil" }}</title>
		<link rel="stylesheet" href="{{ URL::to('foundation-5.5.3/css/foundation.css') }}" />
		<link rel="stylesheet" href="{{ URL::to('select2-foundation5.css') }}" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="{{ URL::to('template/master.css') }}" />
	</head>
	<body
	
	@if(App::make("impersonator")->isImpersonating())
		style = "background-color:yellow"
	@endif
	>
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


		<script src="{{ URL::to('foundation-5.5.3/js/vendor/modernizr.js') }}"></script>
		<script src="{{ URL::to('foundation-5.5.3/js/vendor/jquery.js') }}"></script>
		<script src="{{ URL::to('foundation-5.5.3/js/foundation.min.js') }}"></script>
		
		<script src="{{ URL::to('select2-3.5.4/select2.min.js') }}"></script>

		<script>
			$(document).foundation();
		</script>
		@yield('scripts')
	</body>
</html>
