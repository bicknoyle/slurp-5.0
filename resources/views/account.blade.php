@extends('app')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Storage</div>
	<div class="panel-body">
		<div class="progress">
			<div class="progress-bar" style="width: {{}}%;"></div>
		</div>

		<div class="text-muted">
			{{ $user->results_quota }} results
		</div>
	</div>
</div>
@end