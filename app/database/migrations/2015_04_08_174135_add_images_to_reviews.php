<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagesToReviews extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reviews', function(Blueprint $table)
		{
			$table->string('image');
            $table->boolean('approved');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reviews', function(Blueprint $table)
		{
			$table->dropColumn('image', 'approved');
		});
	}

}
