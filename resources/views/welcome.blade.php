@extends('app')
@section('body')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="jumbotron">
				<h1>Welcome to Slurp</h1>
				<p>Search. Track. Download.</p>
				<p>
					<a class="btn btn-primary" href="{{ url('/auth/register') }}">Register</a>
					<a class="btn btn-default" href="{{ url('/auth/login') }}">Login</a>
				</p>
			</div>
		</div>
	</div>
</div>
@stop