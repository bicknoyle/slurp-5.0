@extends('app')

@section('css')
@parent
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('content')

<p>
	<a href="{{ route('searches.index') }}"><i class="fa fa-arrow-left"></i> Return</a>
</p>

<h2>{{ $search->title }}</h2>

<p class="lead">
	<strong>Query:</strong>
	{{ $search->terms }}<br>
	<strong>Tweets:</strong>
	{{ $search->results()->count() }}
</p>

<p class="lead">
</p>

<div id="results-chart" style="height: 250px;"></div>

<p>
	<a id="results-download" class="btn btn-default" href="{{ route('searches.download', ['searches' => $search->id]) }}"><i class="fa fa-download fa-fw"></i> Download Results</a></br>
	<small><em>Note: All times in downloaded data are Eastern</em></small>
</p>
@stop

@section('js')
@parent
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script>
	/**
	 * 1) Group by date
	 * 2) Put it in a format morris.js likes
	 */
	var json_results = {!! $json_results !!}
	  , tmp = {}
	  , results = []
	;

	for(var i in json_results) {
		var row = json_results[i]
		  , date = moment(row.timestamp * 1000).format('YYYY-MM-DD')
		;

		if ('undefined' === typeof tmp[date]) {
			tmp[date] = row.count;
		}
		else {
			tmp[date] = tmp[date] + row.count;
		}
	}

	for(var i in tmp) {
		results.push({
			'date': i,
			'count': tmp[i]
		});
	}

	new Morris.Line({
		// ID of the element in which to draw the chart.
		element: 'results-chart',
		// Chart data records -- each entry in this array corresponds to a point on
		// the chart.
		data: results,
		// The name of the data record attribute that contains x-values.
		xkey: 'date',
		// A list of names of data record attributes that contain y-values.
		ykeys: ['count'],
		// Labels for the ykeys -- will be displayed when you hover over the
		// chart.
		labels: ['Tweets'],

		xLabels: 'day',

		hideHover: true
	});
</script>
@stop