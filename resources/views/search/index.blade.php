@extends('app')

@section('content')

	@include('errors.list', ['errors' => $errors])

	@if(!Auth::user()->twitter_token)
	<div class="panel panel-success">
		<div class="panel-heading"><strong>Welcome!</strong></div>
		<div class="panel-body">
			<p>Thanks for checking out Slurp! Before getting started, you'll need to <a href="{{ route('connect.twitter') }}">connect your Twitter account</a>.</p>
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

	<h2>Active Searches</h2>
	@forelse($searches as $search)
		<!-- Confirm Delete Modal -->
		<div class="modal fade" id="confirm-delete-{{ $search->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Confirm Action</h4>
					</div>
					<div class="modal-body">
						You are about to permanantly delete <strong>{{ $search->title }}</strong> and all of it's saved results. Are you sure?
					</div>
					<div class="modal-footer">
						{!! Form::open(['route' => ['searches.destroy', $search->id], 'method' => 'delete', 'style' => 'display:inline;']) !!}
							<button type="submit" class="btn btn-danger">Yes, delete</button>
						{!! Form::close() !!}
						<button type="button" data-dismiss="modal" class="btn btn-default">No, cancel</button>
					</div>
				</div>
			</div>
		</div>


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
					<div class="col-sm-4 clearfix">
						<div class="dropdown pull-right">
							<button id="search-menu-{{ $search->id }}" class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Menu</span>
								<i class="fa fa-ellipsis-v"></i>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="search-menu-{{ $search->id }}">
								<li><a href="{{ route('searches.show', ['searches' => $search->id]) }}"><i class="fa fa-line-chart fa-fw"></i> Results</a></li>
								<li><a href="{{ route('searches.download', ['searches' => $search->id]) }}"><i class="fa fa-download fa-fw"></i> Download</a></li>
								<li class="divider"></li>
								<li><a data-toggle="modal" data-target="#confirm-delete-{{ $search->id }}" href><i class="fa fa-trash fa-fw"></i> Delete...</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	@empty
		<p>No searches yet!</p>
	@endforelse

	@endif
@stop