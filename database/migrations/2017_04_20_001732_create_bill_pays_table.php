<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaysTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bill_pays', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date_due');
            $table->string('name');
            $table->float('value');
            $table->boolean('done')->default(false);

			$table->integer('client_id')->unsigned();
			$table->foreign('client_id')->references('id')->on('clients');

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
		Schema::drop('bill_pays');
	}

}
