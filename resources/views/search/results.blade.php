@extends('app')

@section('content')
<h2>Seach Results</h2>
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
				<h5>Results by date</h5>
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
			</div>
		</div>
	</div>
</div>
@stop