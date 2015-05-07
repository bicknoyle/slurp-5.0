<?php namespace App\Console\Commands;

use App\Commands\RunSearch;
use App\Search;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Inspiring;

class SearchesRun extends Command {

	use DispatchesCommands;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'searches:run';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run all user searches';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->comment('Running searches...');
		$searches = Search::all();
		foreach($searches as $search) {
			$this->dispatch(new RunSearch($search->id));
			$this->comment('Running search.id '.$search->id);
		}
	}

}
