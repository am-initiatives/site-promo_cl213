<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
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
			'pos'=> '[46.0898885, 6.5359716]',
			'info' => '[]',
			'active' => 1,
			'hidden' => 1,
			'roles' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'password' => Hash::make('password'),
			'email' => 'corentin.gitton@gadz.org',
			'google_id' => '103503349814606129144',
			'first_name' => 'Corentin',
			'last_name' => 'GITTON',
			'nickname' => 'Tarmak 154',
			'pos'=> '[49.04108, 9.30777]',
			'info' => '[]',
			'active' => 1,
			'hidden' => 0,
			'roles' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'password' => '$2y$10$D8tYXsL9rqWu5EPLIEpJi.WiTE6nwRh0USIz.2DCZYhAaZT8SV9nm',
			'email' => 'adrien.debord@gadz.org',
			'google_id' => null,
			'first_name' => 'Adrien',
			'last_name' => 'Debord',
			'nickname' => 'Gecko 109',
			'connected_at' => '2014-01-01 21:52:35',
			'pos'=> null,
			'info' => '[]',
			'active' => 1,
			'hidden' => 0,
			'roles' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'password' => Hash::make('HMlar\'sssT154'),
			'email' => 'robin.chauvet@gadz.org',
			'google_id' => null,
			'first_name' => 'Robin',
			'last_name' => 'Chauvet',
			'nickname' => 'Notsip 32',
			'pos'=> null,
			'info' => '[]',
			'active' => 1,
			'hidden' => 0,
			'roles' => '[]',
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

		// Ajoute des user créés aléatoirement
		foreach(factory(App\Models\User::class, 20)->make()->all() as $user)
		{
			$user->save();
		}

		Model::reguard();
	}
}
