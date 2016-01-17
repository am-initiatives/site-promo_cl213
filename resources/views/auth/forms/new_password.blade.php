<input type="text" name="email" id="email" autocomplete="off" readonly value="{{ Auth::user()->email }}">
<div>
	<label>Mot de passe
		<input type="password" name="password" id="password" autofocus required autocomplete="off" pattern=".{6,}">
	</label>
</div>
<div>
	<label>Confirmation
		<input type="password" name="password_confirmation" id="password" required pattern=".{6,}">
	</label>
</div>