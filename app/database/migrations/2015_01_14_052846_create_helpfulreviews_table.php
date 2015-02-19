<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpfulreviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('helpfulreviews', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('recipe_id');
			$table->integer('review_id');
			$table->integer('user_id');
			$table->boolean('isHelpful');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('helpfulreviews');
	}

}
