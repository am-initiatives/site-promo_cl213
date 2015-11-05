<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePermissions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function (Blueprint $table) {
			$table->string("role");
			$table->string("permission");
			
			$table->primary(["role","permission"]);
		});

		Schema::table("users",function(Blueprint $table){
			$table->renameColumn('permissions', 'roles');
		});
	}


	public function down()
	{
		Schema::drop('permissions');
		Schema::table("users",function(Blueprint $table){
			$table->renameColumn('roles', 'permissions');
		});
	}
}
