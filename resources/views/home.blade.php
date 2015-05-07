@extends('app')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Storage</div>
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
			<dd>
				<a href="https://twitter.com/intent/user?user_id={{ $user->twitter_id }}" target="_blank">{{ '@'.$user->twitter_screen_name }}</a>
			</dd>
		</dl>
	</div>
</div>
@stop