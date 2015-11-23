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
				array('role' => "admin", "permission" => "all"),

				array('role' => "event", "permission" => "outgo"),

				array('role' => "harpags", "permission" => "appro"),
				array('role' => "harpags", "permission" => "destroy_outgo"),
				array('role' => "harpags", "permission" => "update_buquage"),
				array('role' => "harpags", "permission" => "force_buquage"),
				array('role' => "harpags", "permission" => "last_transactions"),

				array('role' => "ddps", "permission" => "create_event"),
				array('role' => "ddps", "permission" => "store_event"),
				array('role' => "ddps", "permission" => "store_post"),
				array('role' => "ddps", "permission" => "destroy_post"),
			)
		);
	}
}
