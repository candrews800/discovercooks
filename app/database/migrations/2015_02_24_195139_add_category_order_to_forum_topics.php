<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryOrderToForumTopics extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forum_topics', function(Blueprint $table)
		{
			$table->integer('category_id');
            $table->integer('order_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('forum_topics', function(Blueprint $table)
		{
			$table->dropColumn(array('category_id', 'order_id'));
		});
	}

}
