@extends('layouts.logged_out')

@section('body')
<div id="login-advice" style="text-align: center; display: none;"><button class="medium radius button">Connexion</button></div>
@parent
@endsection

@section('scripts')
@parent
<script>
	$(document).ready(function() {
		$("input, button").focus(function() {
			$("#login-panel").fadeTo("slow", 1);
			$("#login-advice").hide("slow");
		});

		$("#login-hide").click(function() {
			$("#login-panel").fadeTo("slow", 0);
			$("#login-advice").show("slow");
		});

		$(document).keyup(function(evt) {
			if (evt.keyCode == 27) {
				if ($("#login-advice").is(":visible")) {
					$("#login-panel").fadeTo("slow", 1);
					$("#login-advice").hide("slow");
				}
				else {
					$("#login-panel").fadeTo("slow", 0);
					$("#login-advice").show("slow");
				}
			}
		});
	});
</script>
@endsection
