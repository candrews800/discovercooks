<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('recipes', function($table)
        {
            $table->increments('id');
            $table->integer('author_id');
            $table->char('private');
            $table->integer('subscriber_count');
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->char('servings', 3);
            $table->char('prep_time', 20);
            $table->char('cook_time', 20);
            $table->char('total_time', 20);
            $table->text('ingredients');
            $table->text('directions');
            $table->string('url');
            $table->string('image');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('recipes');
	}

}
