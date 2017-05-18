<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('code');
			$table->smallInteger('status');

			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('plan_id')->unsigned()->nullable();
			$table->foreign('plan_id')->references('id')->on('plans');

            $table->date('expires_at')->nullable();
            $table->date('canceled_at')->nullable();

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
		Schema::drop('subscriptions');
	}

}
