<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCampaignSlugUniqueIndex extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campaigns', function(Blueprint $table)
		{
			$table->dropUnique('campaigns_slug_unique');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campaigns', function(Blueprint $table)
		{
			$table->unique('slug');
		});
	}

}
