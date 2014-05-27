<?php namespace WeThePeople;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class Cron extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wtp:cron';

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
		$this->description = trans('artisan.cron_description');
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$env = $this->option('env');
		$this->comment('wtp:refresh-petitions');
		$this->call('wtp:refresh-petitions', array('--env' => $env));
		$this->comment('wtp:resend-signatures');
		$this->call('wtp:resend-signatures', array('--env' => $env));
	}

}
