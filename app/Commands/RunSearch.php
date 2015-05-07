<?php namespace App\Commands;

use App\Commands\Command;
use App\Search;
use App\Result;
use Carbon\Carbon;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

use Illuminate\Contracts\Bus\SelfHandling;

use Config;

class RunSearch extends Command implements SelfHandling {

	protected $search_id;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($search_id)
	{
		$this->search_id = $search_id;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$search = Search::find($this->search_id);

		// if not $search, user may have deleted. Return now. This prevents
		// queue errors non-existant objects in the db
		if(!$search) {
			return;
		}

		$user = $search->user;

		// check user quota. We don't mind if they go over during the run, but
		// won't allow future searches to accumulate more results
		$quota = $user->results_quota;
		if(isset($quota) and $user->results()->count() >= $quota) {
			return;
		}

		$client = new Client('https://api.twitter.com/{version}', [
	    	'version' => '1.1'
		]);

		$client->addSubscriber(new OauthPlugin([
			'consumer_key'  => Config::get('services.twitter.client_id'),
			'consumer_secret' => Config::get('services.twitter.client_secret'),
			'token'       => $user->twitter_token,
			'token_secret'  => $user->twitter_secret
		]));

		$request = $client->get('search/tweets.json');

		$since_id = $search->results()->max('message_id') ?: 0;

		$request->getQuery()
			->set('q', $search->terms)
			->set('count', 100)
			->set('since_id', $since_id)
			->set('include_entities', 1)
		;

		// if since_id is zero, this is a first-time run.
		if(0 == $since_id) {
			// nothing here now, see below
		}

		do {
			// NOTE - Guzzle throws an Exception here if rate limit is hit
			$response = $request->send();

			$data = $response->json();

			// load 'em into the db
			foreach($data['statuses'] as $status) {
				$result = new Result([
					'message_id' => array_get($status, 'id'),
					'message_user_id' => array_get($status, 'user.id'),
					'message_screen_name' => array_get($status, 'user.screen_name'),
					'message_created_at' => new Carbon(array_get($status, 'created_at')),
					'message_text' => array_get($status, 'text')
				]);

				$result->extra = [
					'entities' => $status['entities']
				];

				$search->results()->save($result);
			}

			$next = array_get($data, 'search_metadata.next_results');

			// if we have a next_results, create a new request and continue
			// we also need a $since_id, implying this is not a first-run
			if($next and $since_id) {
				$request = $client->get('search/tweets.json'.$next);
				// add since_id, so when we paginate back we don't accidentally
				// get tweets we might've already inserted.
				$request->getQuery()->set('since_id', $since_id);
			}
			// if not, exit loop
			else {
				break;
			}
		} while(true);
	}
}
