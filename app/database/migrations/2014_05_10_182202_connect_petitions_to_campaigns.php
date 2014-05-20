<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectPetitionsToCampaigns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign_petition', function(Blueprint $table)
		{
			$table->integer('campaign_id')->unsigned();
			$table->integer('petition_id')->unsigned();

			$table->foreign('campaign_id')->references('id')->on('campaigns');
			$table->foreign('petition_id')->references('id')->on('petitions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campaign_petition');
	}

}
