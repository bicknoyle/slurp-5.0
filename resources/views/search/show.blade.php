@extends('app')

@section('content')

<p>
	<a href="{{ route('searches.index') }}"><i class="fa fa-arrow-left"></i> Return</a>
</p>

<h2>{{ $search->title }}</h2>

<p class="lead">
	<strong>Terms:</strong>
	{{ $search->terms }}
</p>

<div class="jumbotron">
	<h2>Wouldn't a graph look nice here?</h2>
	<br>
	<br>
	<br>
	<br>
</div>

<table class="table table-striped table-bordered">
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

<p>
	<a class="btn btn-default" href="{{ route('searches.download', ['searches' => $search->id]) }}"><i class="fa fa-download fa-fw"></i> Download Results</a>
</p>
@stop