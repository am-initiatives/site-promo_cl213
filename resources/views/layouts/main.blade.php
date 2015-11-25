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

	// mettre un tag pour le tri oblige à surcharcher l'extraction de texte ce qui fout la merde
	// pour le tri des chiffres du type <strong>100</strong> qui sera alors interprété comme chaine 
	//  $.tablesorter.addParser({ 
	// 	// set a unique id 
	// 	id: 'byTag', 
	// 	is: function(s) { 
	// 		var data = s.match(/sortby="([^"]+)"/);
	// 		return data ? true : false; 
	// 	}, 
	// 	format: function(s) { 
	// 		// format your data for normalization 
	// 		var res =  s.match(/sortby="([^"]+)"/)[1]; 
	// 		return res;
	// 	}
	// }); 
	var solde = /(-?[0-9]{1,2}\.[0-9]{2})\s?€/;
	 $.tablesorter.addParser({ 
		// set a unique id 
		id: 'solde', 
		is: function(s) { 
			var data = s.match(solde);
			return data ? true : false; 
		}, 
		format: function(s) { 
			// format your data for normalization 
			var res =  s.match(solde)[1]; 
			return res;
		},
		type:"numeric"
	}); 
	$(document).ready(function() 
		{ 
			// $(".sortable").tablesorter( {textExtraction: function(node){return node.innerHTML;}}); 
			$(".sortable").tablesorter(); 
		} 
	); 
</script>
@endsection
