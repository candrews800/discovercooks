<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_stats', function(Blueprint $table)
		{
            $table->dropColumn('review_helpful');
            $table->dropColumn('review_nonhelpful');
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
		Schema::table('user_stats', function(Blueprint $table)
		{
            $table->dropColumn('review_with_image');
            $table->integer('review_helpful');
            $table->integer('review_nonhelpful');
		});
	}

}
