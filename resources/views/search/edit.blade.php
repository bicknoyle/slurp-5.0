@extends('app')

@section('content')
	<h2>Edit Search</h2>
	<div class="panel panel-default">
		<div class="panel-heading">
			Id: {{ $search->id }}
		</div>
		<div class="panel-body">
			@include('errors.list', ['errors' => $errors])

			{!! Form::model($search, ['route' => 'searches.update', 'method' => 'put']) !!}
				@include('search._form')
				<button type="submit" class="btn btn-primary">Save Changes</button>
				<a href="{{ route('searches.index') }}" class="btn btn-default">Cancel</a>
			{!! Form::close() !!}
		</div>
	</div>
@stop