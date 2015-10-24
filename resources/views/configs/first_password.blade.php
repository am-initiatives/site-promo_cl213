@extends('layouts.config')

@section('content')
<div class="banner">
	<h3>Nouveau mot de passe</h3>
</div>
<div class="container" id="test" style="position: fixed;">
	<p class="small text-justify">
		Tu devrais configurer un mot de passe pour pouvoir aussi accèder au site sans être connecté avec Gadz.org :
	</p>
	<form>
		@include('auth.forms.new_password')
		<div class="right">
			<input type="button" name="password_confirmation" value="Enregistrer" class="button small" onclick="cacher(); return false;">
		</div>
	</form>
</div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
	function cacher() {
		$('#test').slideToggle("slow");
	}
</script>
@endsection