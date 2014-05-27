<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoreSignatureStatusCode extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('signatures', function(Blueprint $table)
		{
			$table->text('status_description')->after('ip_address')->nullable();
			$table->smallInteger('status')->after('ip_address');
			$table->index('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('signatures', function(Blueprint $table)
		{
			$table->dropIndex('signatures_status_index');
			$table->dropColumn('status_description');
			$table->dropColumn('status');
		});
	}

}
