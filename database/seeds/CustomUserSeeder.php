<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CustomUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
			
		DB::statement('truncate table users');
		DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');

		$users[] = App\Models\User::create([
			'password' => Hash::make('password'),
			'email' => 'webmaster@cl213.fr',
			'google_id' => null,
			'first_name' => 'Admin',
			'last_name' => 'Istrateur',
			'nickname' => 'Admin',
			'pos'=> null,
			'info' => '[]',
			'active' => 1,
			'hidden' => 1,
			'roles' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'password' => Hash::make('lol bank'),
			'email' => 'jb.poquelin@banque.bk',
			'google_id' => null,
			'first_name' => 'Jean-Baptiste',
			'last_name' => 'Poquelin',
			'nickname' => 'Banque',
			'connected_at' => '2014-01-01 21:52:35',
			'pos'=> null,
			'info' => '[]',
			'active' => 1,
			'hidden' => 1,
			'roles' => '[]',
			]);

		Model::reguard();
	}
}
