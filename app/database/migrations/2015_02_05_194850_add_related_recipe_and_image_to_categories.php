<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelatedRecipeAndImageToCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categorys', function(Blueprint $table)
		{
			$table->integer('related_recipe_id');
			$table->string('image');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categorys', function(Blueprint $table)
		{
			$table->dropColumn(array('related_recipe_id', 'image'));
		});
	}

}
