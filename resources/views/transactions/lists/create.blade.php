{!! Form::open(array('route' => ['transactionlist.store'])) !!}
	<div class="row">
		<div class="medium-12 columns">
			<table class="small-12 sortable">
				<thead>
					<th></th>
					<th>Buque</th>
					<th>Fam's</th>
				</thead>
				<tbody>
				@foreach($debitables as $idx => $name)
					<tr>
						<td>
							{!! Form::checkBox('debited[]',$idx, null, ['style'=>'margin: 0px;']) !!}
						</td>
						<td>
							{!! preg_replace('# [-&\d]+#', '', $name, 1) !!}
						</td>
						<td>
							{!! preg_replace('#.* (?=[-&\d]+)#', '', $name, 1) !!}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="medium-9 columns">
			<label>Libellé
				{!! Form::text('wording') !!}
			</label>
		</div>
		<div class="medium-3 columns">
			<label>Montant à Chacun
				{!! Form::text('amount') !!}
			</label>
		</div>
	</div>
	@if($user->isAllowed("force_buquage"))
	<div class="row">
		<div class="column">
			<label>
				{!! Form::checkBox("force",1,true)!!}
				Buquage validé d'office
			</label>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="columns">
			{!! Form::submit('Enregister', ['class' => 'small radius button']) !!}
		</div>
	</div>
{!! Form::close() !!}