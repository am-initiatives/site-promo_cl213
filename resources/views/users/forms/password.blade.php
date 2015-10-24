<div>
	<div class="row">
		<div class="medium-6 columns">
			<label>Ancien mot de passe
				{!! Form::select('debited', $debitables) !!}
			</label>
		</div>
		<div class="medium-6 columns">
			<label>Nouveau mot de passe
				{!! Form::select('credited', $creditables) !!}
			</label>
		</div>
	</div>
</div>