{!! Form::open(array('route' => 'posts.store')) !!}

{!! Form::hidden('category', 'general'); !!}

{!! Form::textarea('body', null, ['rows'=>'2', 'style'=>'margin-bottom: 5px;']); !!}

<div class="text-right">
	<span style="font-size: smaller; color: #777">
		<strong>*gras*</strong> - <i>_italique_</i>
	</span>
	{!! Form::submit('Publier', ['class'=>'button tiny', 'style'=>'margin-bottom: 3px;']) !!}
</div>

{!! Form::close() !!}