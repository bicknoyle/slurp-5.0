<?php namespace App\Console\Commands;

use App\Commands\RunSearch;
use App\Search;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Inspiring;

use Queue;

class SearchesQueue extends Command {

	use DispatchesCommands;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'searches:queue';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Queue user searches';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->comment('Queuing searches...');
		$searches = Search::all();
		foreach($searches as $search) {
			Queue::push(new RunSearch($search->id));
			$this->comment('Queued search.id '.$search->id);
		}
	}

}
