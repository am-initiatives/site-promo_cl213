{!! Form::open(array('route' => 'posts.store')) !!}

{!! Form::hidden('category', 'general'); !!}

{!! Form::textarea('body', null, ['rows'=>'2']); !!}

{!! Form::submit('Envoyer', ['class'=>'button tiny']) !!}

{!! Form::close() !!}