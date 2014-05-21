<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectSignaturesToPetitionsAndCampaigns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('petition_signature', function(Blueprint $table)
		{
			$table->integer('campaign_id')->unsigned();
			$table->integer('petition_id')->unsigned();
			$table->integer('signature_id')->unsigned();

			$table->foreign('campaign_id')->references('id')->on('campaigns');
			$table->foreign('petition_id')->references('id')->on('petitions');
			$table->foreign('signature_id')->references('id')->on('signatures');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('petition_signature');
	}

}
