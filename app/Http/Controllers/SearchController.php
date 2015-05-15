<?php namespace App\Http\Controllers;

use App\Commands\RunSearch;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Result;
use App\Search;
use Carbon\Carbon;
use Guzzle\Plugin\Oauth\OauthPlugin;

use Auth;
use Config;
use DB;
use Queue;
use Redirect;
use Response;
use Session;
use View;

class SearchController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$searches = Auth::user()->searches()->orderBy('created_at', 'desc')->get();

		return View::make('search.index', compact('searches'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('search.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  SearchRequest $request
	 * @return Response
	 */
	public function store(SearchRequest $request)
	{
		$search = new Search($request->all());

		Auth::user()->searches()->save($search);

		Queue::push(new RunSearch($search->id));

		Session::flash('success', 'Created search '.$search->title);

		return Redirect::route('searches.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  SearchRequest $request
	 * @param  Search $search
	 * @return Response
	 */
	public function show(SearchRequest $request, Search $search)
	{
		$daily_results = $search->results()
			->select(DB::raw('DATE(message_created_at) date'), DB::raw('count(*) count'))
			->groupBy('date')
			->orderBy('date')
			->get()
		;

		$json_results = $search->results()
			->select(DB::raw('UNIX_TIMESTAMP(message_created_at) timestamp'), DB::raw('count(*) count'))
			->groupBy('timestamp')
			->orderBy('timestamp')
			->get()
		;

		return View::make('search.show', compact(['search', 'daily_results', 'json_results']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  SearchRequest $request
	 * @param  Search $search
	 * @return Response
	 */
	public function edit(SearchRequest $request, Search $search)
	{
		return View::make('search.edit', compact('search'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// TODO
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  SearchRequest $request
	 * @param  Search $search
	 * @return Response
	 */
	public function destroy(SearchRequest $request, Search $search)
	{
		$search->delete();

		Session::flash('success', 'Search has been deleted');

		return Redirect::route('searches.index');
	}

	/**
	 * Show the search results
	 *
	 * @param  SearchRequest $request
	 * @param  Search $search
	 * @return Response
	 */
	public function results(SearchRequest $request, Search $search)
	{
		$daily_results = $search->results()
			->select(DB::raw('DATE(message_created_at) date'), DB::raw('count(*) count'))
			->groupBy('date')
			->orderBy('date')
			->get()
		;

		return View::make('search.results', compact(['search', 'daily_results']));
	}

	/**
	 * Download search results as a CSV
	 *
	 * @param  SearchRequest $request
	 * @param  Search $search
	 * @return Response
	 *
	 * Adapted from: http://stackoverflow.com/questions/26146719/use-laravel-to-download-table-as-csv/27596496#27596496
	 */
	public function resultsDownload(SearchRequest $request, Search $search)
	{
		// TODO - make filenames that don't suck
		$filename = $search->title.' - '.Carbon::now().'.csv';

	    $headers = [
			'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
			'Content-type'        => 'text/csv',
			'Content-Disposition' => 'attachment; filename="'.$filename.'"',
			'Expires'             => '0',
			'Pragma'              => 'public',
	    ];

	    $results = $search->results()->orderBy('message_id')->get();

		$callback = function() use ($results)
		{
			$FH = fopen('php://output', 'w');

			// print header
			fputcsv($FH, ['id', 'user_id', 'screen_name', 'text', 'created_at', 'permalink']);

			// print rows
			foreach ($results as $result) {
				fputcsv($FH, [
					$result->message_id,
					$result->message_user_id,
					$result->message_screen_name,
					$result->message_text,
					$result->message_created_at,
					'https://www.twitter.com/'.$result->message_screen_name.'/status/'.$result->message_id,
				]);
			}
			fclose($FH);
		};

		return Response::stream($callback, 200, $headers);
	}
}
