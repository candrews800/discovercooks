<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalRecipeReviewToWeeklyStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weekly_stats', function(Blueprint $table)
		{
            $table->integer('total_recipes');
            $table->integer('total_reviews');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('weekly_stats', function(Blueprint $table)
		{
			$table->dropColumn(array('total_recipes', 'total_reviews'));
		});
	}

}
