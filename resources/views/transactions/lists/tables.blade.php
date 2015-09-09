<div class="columns medium-6">
	<table class="small-12">
	    <caption>Comptes crédités</caption>
	    <thead>
	        <th>Propriétaire</th>
	        <th>Montant</th>
	    </thead>
	    <tbody id="credited">
	    	@foreach($debited as $d)
    		<tr>
    			<input type="hidden" name="debited[id][]" value="{{ $d['id'] }}">
    			<td>{{ $d['title'] }}</td>
    			<td><input type="text" name="debited[amount][]" value="{{ $d['amount'] }}"></td>
    		</tr>
    		@endforeach
	    </tbody>
	</table>
</div>
<div class="columns medium-6">
	<table class="small-12">
	    <caption>Comptes crédités</caption>
	    <thead>
	        <th>Propriétaire</th>
	        <th>Montant</th>
	    </thead>
	    <tbody id="credited">
	    	@foreach($credited as $c)
	    	<tr>
	    		<input type="hidden" name="credited[id][]" value="{{ $c['id'] }}">
	    		<td>{{ $c['title'] }}</td>
	    		<td><input type="text" name="credited[amount][]" value="{{ $c['amount'] }}"></td>
	    	</tr>
	    	@endforeach
	    </tbody>
	</table>
</div>