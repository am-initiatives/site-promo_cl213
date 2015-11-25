@extends('layouts.main', ['page_title' => 'Annuaire'])


@section('content')

<div>
@unless(count($users))
	<div class="panel">
		<p class="text-center">Aucun utilisateur.</p>
	</div>
@else
	<div class="row">
		@foreach($users as $user)
<?php
$lines = [];

if (Html::userIcons($user) != '')
	$lines[] = Html::userIcons($user);

foreach ($user->getRoles() as $role) {
	$lines[] = '<span class="label info">' . $role . '</span>';
}

if(Auth::user()->isAllowed("log_as"))
	$lines[] = '<a href="' . route('auth.log_as', $user->id) . '"><i class="fa fa-sign-in"></i></a>';
 ?>
		<div class="columns small-12 medium-6">
			<div class="panel vignette clearfix">
				<a href="{{ route('users.show', $user->id) }}">
					<div class="picture left">
						<img src="{{ $user->getPictureLink() }}">
					</div>
					<div class="information left">
						<ul class="no-bullet">
							<li class="strong">
								@if(in_array($user->nickname, [null, '']))
								{{ $user->last_name }} {{ $user->first_name }}
								@else
								{{ $user->nickname }}<span style="font-size: small;"> ({{ $user->last_name }} {{ $user->first_name }})</span>
								@endif
							</li>
							<li>
								{{ $user->phone }}
							</li>
							<li class="show-for-medium-up">
								{{ $user->email }}
							</li>
							@if(count($user->getRoles()))
							<li>
								@foreach($user->getRoles() as $role)
								<span class="label info">{{ $role }}</span>
								@endforeach
							</li>
							@endif
						</ul>
					</div>
					@if(Auth::user()->isAllowed("log_as"))
					<div class="actions">
						<a href="{{ route('auth.log_as', $user->id) }}">
							<i class="fa fa-sign-in"></i>
						</a>
					</div>
					@endif
				</a>
			</div>
			
		</div>
		@endforeach
	</div>
@endunless
</div>

@endsection