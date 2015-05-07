<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('results', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('search_id')->unsigned();
			$table->bigInteger('message_id')->unsigned();
			$table->integer('message_user_id')->unsigned();
			$table->string('message_screen_name');
			$table->timestamp('message_created_at');
			$table->text('message_text');
			$table->text('extra');
			$table->timestamps();

			$table->foreign('search_id')->references('id')->on('searches')->onDelete('cascade');
			$table->unique(['search_id', 'message_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('results');
	}

}
