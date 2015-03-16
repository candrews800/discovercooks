<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_stats', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('page_views');
            $table->integer('total_recipes');
            $table->integer('total_reviews');
            $table->integer('review_helpful');
            $table->integer('review_nonhelpful');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_stats');
	}

}
