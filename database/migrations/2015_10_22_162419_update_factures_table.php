<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFacturesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function (Blueprint $table) {
			$table->enum('state', ['pending', 'acquited']);
			$table->char('group_id',36);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function (Blueprint $table) {
			 $table->dropColumn('state');
			 $table->dropColumn('group_id');
		});
	}
}
