<div>
	<div class="row">
		<div class="medium-6 columns">
			<label>Compte à débiter
				{!! Form::select('debited', $debitables) !!}
			</label>
		</div>
		<div class="medium-6 columns">
			<label>Compte à créditer
				{!! Form::select('credited', $creditables) !!}
			</label>
		</div>
	</div>
	<div class="row">
		<div class="medium-9 columns">
			<label>Libellé
				{!! Form::text('wording') !!}
			</label>
		</div>
		<div class="medium-3 columns">
			<label>Montant
				{!! Form::text('amount') !!}
			</label>
		</div>
	</div>
	<div class="row">
		<div class="columns">
			{!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
		</div>
	</div>
</div>