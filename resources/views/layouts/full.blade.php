@extends('layouts.master')

@section('styles')
@parent
<style type="text/css">
	html, body { height: 100%; margin: 0; padding: 0; }
	.top-bar {width: 100%; }
</style>
@endsection

@section('body')
<nav class="top-bar" data-topbar role="navigation">
	<section class="top-bar-section">
		<!-- Right Nav Section -->
		<ul class="right">
			<li><a href="#" onclick="$('nav').hide()">Cacher cette barre</a></li>
		</ul>


		<!-- Left Nav Section -->
		<ul class="left">
			<li><a href="{{ route('tools.map') }}"><i class="fa fa-chevron-left"></i> Revenir sur le site</a></li>
		</ul>
	</section>
</nav>

@yield('content')
@endsection
