@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="columns medium-4">
			<a href="{{ route('users.show', $user->id) }}">
				<div class="panel">
					<img style="width: 70px;" src="{{ $user->getPictureLink() }}">
				</div>
			</a>
			<a href="{{ route('accounts.show', $user->account->id) }}">
				<div class="panel" style="text-align: center;">
					Solde : {!! Html::solde($user->account->getBalance() / 100, '€') !!}
				</div>
			</a>
			<a href="{{ route('tools.map') }}">
				<div class="panel">
					<h5>Où sont mes prom'sssquets ?</h5>
					<img style="width: 100%;" src="{{ url('images/map.png') }}">
				</div>
			</a>
		</div>
		<div class="columns medium-8">
			<h4>Actualité</h4>
			@foreach($posts as $post)
				<div class="panel post">
					<div class="header">
						<div class="picture">
							<a href="{{ $post->user->getLink() }}">
								<img style='height: 50px;' src="{{ $post->user->getPictureLink() }}">
							</a>
						</div>
						<div class="info">
							{!! $post->user->getLinkTitle() !!}
							<br/>
							<span style="color: #777">{{ Html::diff($post->created_at) }}</span>
						</div>
					</div>
					@if(isset($post->title))
					<div>
						<h3>{{ $post->title }}</h3>
					</div>
					@endif
					<div>
						{{ $post->body }}
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection