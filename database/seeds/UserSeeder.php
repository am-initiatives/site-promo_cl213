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

		$users[] = App\Models\User::create([
			'username' => 'admin',
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
			'permissions' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'username' => 'tarmak',
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
			'permissions' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'username' => 'iwazaru',
			'password' => '',
			'email' => 'mathieu.tudisco@gadz.org',
			'google_id' => null,
			'first_name' => 'Mathieu',
			'last_name' => 'Tudisco',
			'nickname' => 'Iwazaru 134',
			'pos'=> '[48.8178079, 2.3332474]',
			'info' => '[]',
			'active' => 1,
			'hidden' => 1,
			'permissions' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'username' => 'gecko',
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
			'permissions' => '["admin"]',
			]);

		$users[] = App\Models\User::create([
			'username' => 'notsip',
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
			'permissions' => '[]',
			]);

		$users[] = App\Models\User::create([
			'username' => 'Banque',
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
			'permissions' => '[]',
			]);

		// Ajoute des user créés aléatoirement
		$users = array_merge($users, factory(App\Models\User::class, 20)->make()->all() );

		Model::reguard();

		return $users;
	}
}
