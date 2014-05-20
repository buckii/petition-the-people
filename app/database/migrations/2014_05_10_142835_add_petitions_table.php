<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPetitionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('petitions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('wtp_id')->unique();
			$table->string('title');
			$table->text('body');
			$table->integer('signature_threshold')->unsigned();
			$table->integer('signature_count')->unsigned();
			$table->integer('signatures_needed')->unsigned();
			$table->string('url');
			$table->datetime('deadline');
			$table->string('status', 12);
			$table->timestamps();

			$table->unique('id');
			$table->index('deadline');
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
		Schema::drop('petitions');
	}

}
