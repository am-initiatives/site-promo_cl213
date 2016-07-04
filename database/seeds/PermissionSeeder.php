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
			[
				['role' => "admin", "permission" => "all"],

				['role' => "event", "permission" => "create_outgo"],

				['role' => "harpags", "permission" => "appro"],
				['role' => "harpags", "permission" => "destroy_outgo"],
				['role' => "harpags", "permission" => "update_buquage"],
				['role' => "harpags", "permission" => "force_buquage"],
				['role' => "harpags", "permission" => "last_transactions"],

				['role' => "ddps", "permission" => "create_event"],
				['role' => "ddps", "permission" => "store_event"],
				['role' => "ddps", "permission" => "store_post"],
				['role' => "ddps", "permission" => "destroy_post"],
			]
		);
	}
}
