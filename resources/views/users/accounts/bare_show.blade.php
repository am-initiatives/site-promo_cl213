<ul class="tabs" data-tab>
	<li class="tab-title {{session('credit_tab') ? '': 'active' }}"><a href="#debits">Débits</a></li>
	<li class="tab-title {{!session('credit_tab') ? '': 'active' }}"><a href="#credits">Crédits</a></li>
</ul>

<div class="tabs-content">
	<div class="content {{session('credit_tab') ? '': 'active' }}" id="debits">
		@unless(count($debits))
		<p>Aucun débit pour le moment.</p>
		@else
		<table class="small-12">
			<thead>
				<th>Etat</th>
				<th>Date</th>
				<th>Libellé</th>
				<th>Émetteur</th>
				<th>Montant</th>
			</thead>
			<tbody>
				@foreach($debits as $transaction)
					<tr>
						<td style="text-align:center">
						@if($transaction['state']=="pending")
							{{-- bouton payer --}}
							@if($solde + $transaction["amount"]>0 && Auth::user()->isAllowed("update_buquage",$user->id))
								{!! Form::open(array('route' => 
									['transactions.update',$transaction["id"]], 'method' => 'put')) !!}
									{!! Form::hidden("user",$user->id) !!}
									<input type="submit" class="tiny button alert" value ="Payer" style="margin:0" />
								{!! Form::close() !!}
							@else
							<i class="fa fa-times-circle fa-2" style="color:red"></i>
							@endif
						@else
							<i class="fa fa-check-circle fa-2" style="color:green"></i>
						@endif
						</td>
						<td>{{ $transaction['date'] }}</td>
						<td><strong>{{ $transaction['wording'] }}</strong></td>
						<td>{{ $transaction['account'] }}</td>
						<td style="text-align: right;">
							{!! Html::solde($transaction['amount']) !!}
							@if(
								Auth::user()->isAllowed("destory_transactions",$transaction['account_id'])
								|| ($transaction['account_id'] == App\Models\User::getBankAccount()->id 
								&& Auth::user()->isAllowed("destory_outgo",$user->id))
							)
							<span>
							{!! Form::open(array('route' => 
								['transactions.destroy',$transaction['id']], 'method' => 'delete','style'=>"display:inline")) !!}
								<button type="submit" style="background-color:white;color:red;padding:0;margin:0">
									<i class="fa fa-times-circle fa-1"></i>
								</button>
							{!! Form::close() !!}
							</span>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		@endunless
	</div>
	<div class="content {{!session('credit_tab') ? '': 'active' }}" id="credits">
		@unless(count($credits))
		<p>Aucun crédit pour le moment.</p>
		@else
		<ul class="accordion" data-accordion>
		@foreach($credits as $gpe => $credit)
			<li class="accordion-navigation">
				{{-- entête --}}
				<a href="#a{{$gpe}}" aria-expanded="false" class="row">
					<div class="medium-1 columns">
						{!! Html::solde($credit['amount']) !!}
					</div>
					<div class="medium-3 columns">
						<b>{{$credit["wording"]}}</b>
					</div>
					<div class="medium-7 columns radius progress success">
						<span class="meter" style="width: {{$credit['acquited']/$credit['total']*100}}%">
						</span>
					</div>
					<div class="medium-1 columns" style="text-align: center;">
						{{$credit['acquited']}}/{{$credit['total']}}
					</div>
				</a>
				{{-- liste des gens buqués --}}
				<div id="a{{$gpe}}" class="content">
					<table class="large-12">
					@foreach($credit["rows"] as $transaction)
					<tr>
						<td class="medium-1" style="text-align:center">
						@if($transaction['state']=="pending")
							<i class="fa fa-times-circle fa-2" style="color:red"></i>
						@else
							<i class="fa fa-check-circle fa-2" style="color:green"></i>
						@endif
						</td>
						<td class="medium-5">
							{{$transaction["account"]}}
						</td>
						<td class="medium-4">
							depuis le 
							{{$transaction["date"]}}
						</td>
						<td class="medium-2" style="text-align:right">
							{{-- Bouton Retirer une personne --}}
							@if(Auth::user()->isAllowed("destroy_buquage",$user->id))
							{!! Form::open(array('route' => 
								['transactions.destroy',$transaction['id']], 'method' => 'delete')) !!}
									<input type="submit" class="button tiny alert" style="margin:0" value="Retirer">
							{!! Form::close() !!}
							@endif
						</td>
					</tr>
					@endforeach
					</table>
					<ul class="button-group">
						{{-- Bouton ajouter quelqu'un --}}
						@if(Auth::user()->isAllowed("edit_buquage",$user->id))
						<li>
						{!! Form::open(array('route' => 
							['transactionlist.edit',$gpe], 'method' => 'get')) !!}
							<input type="submit" class="button tiny" value="Ajouter quelqu'un">
						{!! Form::close() !!}
						@endif
						</li>
						{{-- Bouton supprimer tout --}}
						@if(Auth::user()->isAllowed("destroy_buquage_list",$user->id))
						<li>
						{!! Form::open(array('route' => 
							['transactionlist.destroy',$gpe], 'method' => 'delete')) !!}
								<input type="submit" class="button tiny alert" value="Supprimer Toute la liste">
						{!! Form::close() !!}
						</li>
						@endif
					</ul>
				</div>
			</li>
		@endforeach
		</ul>
		@endunless
	</div>
</div>
