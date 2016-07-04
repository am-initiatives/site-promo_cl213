<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;


class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::transaction(function(){

			$this->call(PermissionSeeder::class);
			$this->call(CustomUserSeeder::class);

			// Random users
			foreach(factory(App\Models\User::class, 20)->make()->all() as $user)
			{
				$user->save();
			}

			DB::statement('truncate table posts');
			DB::table('posts')->insert(
				array(
					array('user_id' => 2, 'category' => 'general', 'body' => 'Site en cours de développement, de nouvelles fonctionnalités arriveront au fûr et à mesure.', 'created_at' => Carbon::now()->subMinutes(154), 'updated_at' => Carbon::now()->subMinutes(154)),
				));

			DB::statement('truncate table transactions');
			foreach(factory(App\Models\Transaction::class, 100)->make()->all() as $transaction)
			{
				$transaction->save();
			}

			// throw new Exception("Rollback", 1);
			
		});
	}
}
