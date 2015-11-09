@extends('layouts.main')

@section('content')

<div class="panel">
@unless(count($users))
	<p class="text-center">Aucun utilisateur.</p>
@else
	<div class="row">
		@foreach($users as $user)
		<div class="columns small-12 medium-6">
			<div class="vignette clearfix">
				<div class="picture left">
					<img src="{{ $user->getPictureLink() }}">
				</div>
				<div class="information left">
					@if(in_array($user->nickname, [null, '']))
					<a href="{{ route('users.show', $user->id) }}">{{ $user->last_name }} {{ $user->first_name }}</a>
					@else
					<a href="{{ route('users.show', $user->id) }}">{{ $user->nickname }} <span style="font-size: small">({{ $user->last_name }} {{ $user->first_name }})</span></a>
					@endif
					<br/>
					{{ $user->email }}<br/>
					{{ $user->phone }}<br/>
				</div>
				<div class="actions right text-right">
					{!! Html::userIcons($user) !!}
					@foreach($user->getRoles() as $role)
					<br/>
					<span class="label info">{{ $role }}</span>
					@endforeach
					@if(Auth::user()->isAllowed("log_as"))
						@if(!in_array(Html::userIcons($user), [null, '']))
						<br/>
						@endif
						<a href="{{route('auth.log_as',$user->id)}}">
							<i class="fa fa-sign-in"></i>
						</a>
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
@endunless
</div>

@endsection