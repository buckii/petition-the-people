<?php namespace WeThePeople;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class ResendPetitions extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wtp:resend-petitions';

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
		$this->description = trans('artisan.resend_petitions_description');
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$signatures = \Signature::failed()->get();
		$counter = array(
			'success' => 0,
			'failure' => 0
		);
		$api = new \WeThePeopleApi;

		$this->info( trans( 'artisan.resend_petitions_heading', [ 'signature_count' => count( $signatures ) ] ) . PHP_EOL );

		foreach ( $signatures as $signature ) {
			$sig = $signature->toArray();

			try {
        $signature->petitions->each( function ( $petition ) use ( $api, $signature ) {
          $api->signature( $petition->wtp_id, $signature );
        });

      } catch ( \GuzzleHttp\Exception\ServerException $e ) {
        $signature->status = $e->getResponse()->getStatusCode();
        if ( $e->hasResponse() ) {
          $signature->status_description = $e->getResponse()->getReasonPhrase();
        }
        $signature->save();
        $this->error( trans( 'artisan.resent_signature_error', $sig ) );
        $counter['failure']++;
      }

      $signature->status = 200;
      $signature->status_description = null;
      $signature->save();
      $this->info( trans( 'artisan.resend_signature_successful', $sig ) );
      $counter['success']++;
		}

		$this->info( PHP_EOL . trans( 'artisan.resend_petitions_summary', $counter ) );
	}

}
