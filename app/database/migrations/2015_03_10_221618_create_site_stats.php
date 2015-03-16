<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_stats', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('total_recipes');
            $table->integer('total_reviews');
            $table->integer('page_views');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_stats');
	}

}
