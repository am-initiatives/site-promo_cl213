<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('truncate table permissions');
		DB::table('permissions')->insert(
			array(
				array('role' => "admin", "permission"=>"all"),
			)
		);
	}
}
