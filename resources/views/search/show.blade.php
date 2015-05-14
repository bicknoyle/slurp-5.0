@extends('app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirm Action</h4>
			</div>
			<div class="modal-body">
				You are about to permanantly delete this search and all saved results. Are you sure?
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

<h2>Search Details</h2>
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
		</div>
		<div class="row">
			<div class="col-xs-12">
				<h3>Results by date</h3>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Count</th>
						</tr>
					</thead>
					<tbody>
						@foreach($daily_results as $result)
						<tr>
							<th scope="row">{{ $result->date }}</th>
							<td>{{ $result->count }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>

				<a class="btn btn-default" href="{{ route('searches.download', ['searches' => $search->id]) }}">Download <i class="fa fa-download"></i></a>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="text-right">
			<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete" title="Delete search...">
				<span class="sr-only">Delete Search</span>
				<i class="fa fa-trash-o fa-lg"></i>
			</button>
		</div>
	</div>
</div>
@stop