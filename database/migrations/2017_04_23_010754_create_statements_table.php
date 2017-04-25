<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statements', function(Blueprint $table) {
            $table->increments('id');
			$table->float('value');
			$table->float('balance');

			$table->integer('bank_account_id')->unsigned();
			$table->foreign('bank_account_id')->references('id')->on('bank_accounts');

			$table->integer('client_id')->unsigned();
			$table->foreign('client_id')->references('id')->on('clients');

			$table->integer('statementable_id')->unsigned();
			$table->string('statementable_type');

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
		Schema::drop('statements');
	}

}
