@extends('app')

@section('content')

	@include('errors.list', ['errors' => $errors])

	@if(!Auth::user()->twitter_token)
	<div class="panel panel-success">
		<div class="panel-heading">Success</div>
		<div class="panel-body">
			<p>Thanks for checking out Slurp! Before creating searches we need you to connect your Twitter account.</p>
			<ul class="list-unstyled">
				<li><a href="{{ route('connect.twitter') }}" class="btn btn-default"><i class="fa fa-twitter"></i> Connect Twitter Account</a></li>
			</ul>
		</div>
	</div>
	@else

	<h2>Create Search</h2>
	{!! Form::open(['route' => 'searches.store', 'class' => 'form-inline']) !!}
		<div class="form-group">
			{!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Search title']) !!}
		</div>
		<div class="form-group">
			{!! Form::text('terms', null, ['class' => 'form-control', 'placeholder' => 'Search query']) !!}
		</div>

		<button type="submit" class="btn btn-primary">Create Search</button>
	{!! Form::close() !!}

	<h2>Current Searches</h2>
	@forelse($searches as $search)
		<div class="panel panel-default">
			<div class="panel-heading">{{ $search->title }}</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-8">
						<div class="lead">{{ $search->terms }}</div>
						<p>{{ $search->results()->count() }} results</p>
						<p>
							<small class="text-muted">(created {{ $search->created_at->diffForHumans() }})</small>
						</p>
					</div>
					<div class="col-sm-4 text-right">
						<a class="btn btn-default" href="{{ route('searches.results', ['searches' => $search->id]) }}">View Results <i class="fa fa-eye"></i></a>
						<a class="btn btn-default" href="{{ route('searches.results.download', ['searches' => $search->id]) }}">Download <i class="fa fa-download"></i></a>

						{{-- <a class="btn btn-success" href="{{ route('searches.run', ['searches' => $search->id]) }}" title="Run Now"><span class="sr-only">Run Now</span><i class="fa fa-refresh"></i></a> --}}

						{!! Form::open(['route' => ['searches.destroy', $search->id], 'method' => 'delete', 'style' => 'display:inline;']) !!}
							<button type="submit" class="btn btn-danger">
								<span class="sr-only">Delete</span>
								<i class="fa fa-trash-o fa-lg"></i>
							</button>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	@empty
		<p>No searches yet!</p>
	@endforelse

	@endif
@stop