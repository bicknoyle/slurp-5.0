@extends('app')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Info</div>
	<div class="panel-body">
		<div>
			<div class="form-group">
				<label>Avatar</label>
				<div>
					<img class="img-rounded" src="http://www.gravatar.com/avatar/{{ md5($user->email) }}?s=190" alt=""/>
				</div>
				<small>Update your avatar at <a href="http://gravatar.com" target="_blank">gravatar.com</a></small>
			</div>

			<div class="form-group">
				{!! Form::label('name') !!}
				{!! Form::text('name', $user->name, ['class' => 'form-control', 'disabled']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('email') !!}
				{!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled']) !!}
			</div>

			{{--
			<div class="form-group">
				{!! Form::label('password') !!}
				{!! Form::password('password', ['class' => 'form-control', 'disabled']) !!}
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Update Info</button>
			</div>
			--}}
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Usage</div>
	<div class="panel-body">
		@if(is_null($user->results_quota))
			<p>Your results storage is <strong>unlimited</strong>.</p>
		@else
			@if($user->results()->count() > $user->results_quota)
				<div class="alert alert-warning">
					<strong>Uh-oh!</strong> Looks like you've hit or exceeded your results storage quota.
				</div>
			@endif

			<p>Currently storing {{ number_format($user->results()->count()) }} results of your {{ number_format($user->results_quota) }} storage quota</p>
			<div class="progress">
				<div class="progress-bar progress-bar-success" style="width: {{ round(($user->results()->count() / $user->results_quota) * 100, 0) }}%;"></div>
			</div>
		@endif
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Connected Accounts</div>
	<div class="panel-body">
		<dl class="dl-horizontal">
			<dt>
				Twitter
			</dt>
			<dd>@if($user->twitter_screen_name)
				<a href="https://twitter.com/intent/user?user_id={{ $user->twitter_id }}" target="_blank">{{ '@'.$user->twitter_screen_name }}</a>
				@else
				<a href="{{ route('connect.twitter') }}" class="btn btn-default btn-xs"><i class="fa fa-twitter"></i> Connect Twitter Account</a>
				@endif
			</dd>
		</dl>
	</div>
</div>
@stop