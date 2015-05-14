<?php namespace App\Http\Controllers;

use Auth;
use Redirect;
use Socialize;
use Session;
use View;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();

		return View::make('home', compact('user'));
	}

	public function connectTwitter()
	{
		return Socialize::with('twitter')->redirect();
	}

	public function connectTwitterCallback()
	{
		$account = Socialize::with('twitter')->user();

		// TODO - should we update this every time tho?
		Auth::user()->update([
			'twitter_id' => $account->id,
			'twitter_screen_name' => $account->nickname,
			'twitter_token'	=> $account->token,
			'twitter_secret' => $account->tokenSecret
		]);

		Session::flash('success', 'Twitter account connected.');

		return Redirect::route('searches.index');
	}

}
