<div class="form-group">
	{!! Form::label('title') !!}
	{!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('terms') !!}
	{!! Form::text('terms', null, ['class' => 'form-control']) !!}
	<small>
		<i class="fa fa-info-circle"></i>
		See Twitter's <a href="https://dev.twitter.com/rest/public/search" target="_blank">Search API documentation</a> for usage examples
	</small>
</div>