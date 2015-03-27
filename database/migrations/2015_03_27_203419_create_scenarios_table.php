<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScenariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scenarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('scenario');
			$table->timestamps();
		});
		Schema::create('answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('answer');
			$table->integer('next_scenario')->length(10)->unsigned();
			$table->foreign('next_scenario')
				->references('id')->on('scenarios')
				->onDelete('cascade');
			$table->integer('dependant_answer')->length(10)->unsigned()
				->default(null)
				->nullable();
			$table->foreign('dependant_answer')
				->references('id')->on('answers')
				->onDelete('set null');
			$table->timestamps();
		});
		Schema::create('scenario_answers', function(Blueprint $table)
		{
			$table->integer('scenario')->length(10)->unsigned();
			$table->foreign('scenario')
				->references('id')->on('scenarios')
				->onDelete('cascade');
			$table->integer('answer')->length(10)->unsigned();
			$table->foreign('answer')
				->references('id')->on('answers')
				->onDelete('cascade');
		});
		
		Schema::create('user_story', function(Blueprint $table)
		{
			$table->integer('user')->length(10)->unsigned();
			$table->integer('scenario')->length(10)->unsigned();
			$table->integer('answer')->length(10)->unsigned();
		});
		Schema::table('user_story', function(Blueprint $table)
		{
			$table->foreign('user')
				->references('id')->on('users')
				->onDelete('cascade');
			$table->foreign('scenario')
				->references('id')->on('scenarios')
				->onDelete('cascade');
			$table->foreign('answer')
				->references('id')->on('answers')
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
		Schema::drop('user_story');
		Schema::drop('scenario_answers');
		Schema::drop('answers');
		Schema::drop('scenarios');
	}

}
