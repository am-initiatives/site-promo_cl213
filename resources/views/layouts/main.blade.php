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

	var solde = /(-?[0-9]{1,3}(,[0-9]{3})*\.[0-9]{2})\s?€/;
	 $.tablesorter.addParser({ 
		// set a unique id 
		id: 'solde', 
		is: function(s) { 
			var data = s.match(solde);
			return data ? true : false; 
		}, 
		format: function(s) { 
			// format your data for normalization 
			var res =  s.match(solde)[1].replace(",",""); 
			return res;
		},
		type:"numeric"
	}); 
	$(document).ready(function() 
		{ 
			$(".sortable").tablesorter( {textExtraction: function(node){
				//va chercher un éventuel tag "sortby" dans le noeud parent
				//pour l'utiliser pour le tri
				var text = node.getAttribute("sortby");
				if(!text)
				{
					//etrait de la lib de base
					var supportsTextContent = node.textContent || false;
					if (supportsTextContent) {
						text = node.textContent;
					} else {
						if (node.childNodes[0] && node.childNodes[0].hasChildNodes()) {
							text = node.childNodes[0].innerHTML;
						} else {
							text = node.innerHTML;
						}
					}
				}

				return text;
			}}); 
		} 
	); 
</script>
@endsection
