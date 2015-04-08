<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCaptionDetailToFeaturedRecipes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('featured_recipes', function(Blueprint $table)
		{
			$table->integer('caption_style');
            $table->string('caption_text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('featured_recipes', function(Blueprint $table)
		{
			$table->dropColumn('caption_style', 'caption_text');
		});
	}

}
