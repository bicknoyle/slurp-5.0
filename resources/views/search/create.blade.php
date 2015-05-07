@extends('app')

@section('content')
	<h2>Create Search</h2>
	<div class="panel panel-default">
		<div class="panel-heading">
			New Search
		</div>
		<div class="panel-body">
			@include('errors.list', ['errors' => $errors])

			{!! Form::open(['route' => 'searches.store']) !!}
				@include('search._form')
				<button type="submit" class="btn btn-success">Add Search</button>
				<a href="{{ route('searches.index') }}" class="btn btn-default">Cancel</a>
			{!! Form::close() !!}
		</div>
	</div>
@stop