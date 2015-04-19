<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWeeklyStatsArchive extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weekly_stats_archive', function(Blueprint $table)
		{
            $table->dropColumn('review_helpful');
            $table->dropColumn('review_nonhelpful');
            $table->integer('tickets');
            $table->integer('review_with_image');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('weekly_stats_archive', function(Blueprint $table)
		{
            $table->integer('review_helpful');
            $table->integer('review_nonhelpful');
            $table->dropColumn('tickets');
            $table->dropColumn('review_with_image');
		});
	}

}
