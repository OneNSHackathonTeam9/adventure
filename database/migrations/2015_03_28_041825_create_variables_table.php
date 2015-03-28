<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                Schema::create('user_variables', function(Blueprint $table) {
			$table->integer('user')->length(10)->unsigned();
			$table->string('key');
			$table->string('value');
		});
                Schema::table('user_variables', function(Blueprint $table) {
			$table->foreign('user')
				->references('id')->on('users')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
                Schema::drop('user_variables');
	}

}
