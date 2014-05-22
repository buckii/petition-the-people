<?php namespace WeThePeople;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class RefreshPetitions extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wtp:refresh-petitions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->description = trans('artisan.refresh_petitions_description');
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info( trans( 'artisan.refresh_petitions_heading' ) . PHP_EOL );
		$date = Carbon::now()->subHour()->toDateTimeString();
		$counter = 0;

		foreach ( $petitions = \Petition::where( 'updated_at', '<=', $date )->get() as $petition ) {
			if ( \PetitionController::maybeRefresh( $petition->id ) ) {
				$this->info( trans( 'artisan.petition_updated_line', array( 'id' => $petition->id, 'title' => $petition->title	) ) );
				$counter++;
			}
		}

		$this->info( PHP_EOL . \Lang::choice( 'artisan.refresh_petitions_summary', $counter, [ 'updated' => $counter ] ) );
	}

}
