<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileinfoToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('hometown');
			$table->string('location');
			$table->string('hobbies');
			$table->string('facebook');
			$table->string('twitter');
			$table->string('pinterest');
			$table->string('website');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn(array('hometown', 'location', 'hobbies', 'facebook', 'twitter', 'pinterest', 'website'));
		});
	}

}
