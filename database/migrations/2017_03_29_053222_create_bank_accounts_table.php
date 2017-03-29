<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_accounts', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('agency')->nullable();
			$table->string('account')->nullable();
			$table->boolean('default')->default(0);

			$table->integer('bank_id')->unsigned();
			$table->foreign('bank_id')->references('id')->on('banks');

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
		Schema::drop('bank_accounts');
	}

}
