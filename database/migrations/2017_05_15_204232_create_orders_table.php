<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date_due');
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_url');
            $table->string('code');
            $table->smallInteger('status');
            $table->float('value');

            $table->integer('subscription_id')->unsigned();
            $table->foreign('subscription_id')->references('id')->on('subscriptions');

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
		Schema::drop('orders');
	}

}
