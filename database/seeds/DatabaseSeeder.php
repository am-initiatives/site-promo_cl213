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
        Model::unguard();

        DB::beginTransaction();

        DB::table('users')->insert(
            array(
                array('username' => 'admin', 'password' => Hash::make('password'), 'email' => 'webmaster@cl213.fr', 'google_id' => null, 'first_name' => 'Admin', 'last_name' => 'Istrateur', 'nickname' => '', 'pos'=> '[46.0898885, 6.5359716]', 'info' => '[]', 'active' => 1, 'hidden' => 1, 'permissions' => '["admin"]'),
                array('username' => 'tarmak', 'password' => '', 'email' => 'corentin.gitton@gadz.org', 'google_id' => '103503349814606129144', 'first_name' => 'Corentin', 'last_name' => 'Gitton', 'nickname' => 'Tarmak 154', 'pos'=> '[49.04108, 9.30777]', 'info' => '[]', 'active' => 1, 'hidden' => 0, 'permissions' => '["admin"]'),
                array('username' => 'iwazaru', 'password' => '', 'email' => 'mathieu.tudisco@gadz.org', 'google_id' => null, 'first_name' => 'Mathieu', 'last_name' => 'Tudisco', 'nickname' => 'Iwazaru 134', 'pos'=> '[48.8178079, 2.3332474]', 'info' => '[]', 'active' => 1, 'hidden' => 1, 'permissions' => '["admin"]'),
                array('username' => 'notsip', 'password' => '', 'email' => 'robin.chauvet@gadz.org', 'google_id' => null, 'first_name' => 'Robin', 'last_name' => 'Chauvet', 'nickname' => 'Notsip 32', 'pos'=> null, 'info' => '[]', 'active' => 1, 'hidden' => 0, 'permissions' => ''),
                array('username' => 'gecko', 'password' => '', 'email' => 'adrien.debord@gadz.org', 'google_id' => null, 'first_name' => 'Adrien', 'last_name' => 'Debord', 'nickname' => 'Gecko 109', 'pos'=> null, 'info' => '[]', 'active' => 1, 'hidden' => 0, 'permissions' => '["admin"]'),
                array('username' => 'user2', 'password' => '', 'email' => 'user2@gadz.org', 'google_id' => null, 'first_name' => 'User2', 'last_name' => 'User2', 'nickname' => 'User2', 'pos'=> null, 'info' => '[]', 'active' => 0, 'hidden' => 0, 'permissions' => '["admin"]'),
                array('username' => 'user3', 'password' => '', 'email' => 'user3@gadz.org', 'google_id' => null, 'first_name' => 'User3', 'last_name' => 'User3', 'nickname' => 'User3', 'pos'=> null, 'info' => '[]', 'active' => 0, 'hidden' => 0, 'permissions' => '["admin"]'),
                array('username' => 'user4', 'password' => '', 'email' => 'user4@gadz.org', 'google_id' => null, 'first_name' => 'User4', 'last_name' => 'User4', 'nickname' => 'User4', 'pos'=> null, 'info' => '[]', 'active' => 0, 'hidden' => 0, 'permissions' => '["admin"]'),
                array('username' => 'user5', 'password' => '', 'email' => 'user5@gadz.org', 'google_id' => null, 'first_name' => 'User5', 'last_name' => 'User5', 'nickname' => 'User5', 'pos'=> null, 'info' => '[]', 'active' => 0, 'hidden' => 0, 'permissions' => '["admin"]'),
                array('username' => 'user6', 'password' => '', 'email' => 'user6@gadz.org', 'google_id' => null, 'first_name' => 'User6', 'last_name' => 'User6', 'nickname' => 'User6', 'pos'=> null, 'info' => '[]', 'active' => 0, 'hidden' => 0, 'permissions' => '["admin"]'),
            ));

        DB::table('accounts')->insert(
            array(
                array('user_id' => null, 'description' => 'Prom\'sss', 'restricted' => 0, 'active' => 1),
                array('user_id' => 1, 'description' => 'Tarmak 154', 'restricted' => 1, 'active' => 1),
                array('user_id' => 2, 'description' => 'User', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Bidule', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Bousin', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Gourou', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Voiré', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Michel', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Zapneu', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Cochone', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Nicole', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Gorgu', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Fofo', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Balou', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Girafe', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Popole', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Francis', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Pétrolette', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Jiji', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Kouala', 'restricted' => 1, 'active' => 1),
                array('user_id' => null, 'description' => 'Poyo', 'restricted' => 1, 'active' => 1),
            ));

        DB::table('transactions')->insert(
            array(
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 15400, 'wording' => 'Dépot', 'active' => 1, 'created_at' => '2014-01-01 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 2, 'amount' => 154, 'wording' => 'Bons et loyaux services', 'active' => 1, 'created_at' => '2014-02-25 21:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 124, 'wording' => 'Lorem ipsum dolor sit', 'active' => 1, 'created_at' => '2014-02-22 21:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 4514, 'wording' => 'amet, consectetur adipisicing', 'active' => 1, 'created_at' => '2014-03-12 21:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 3, 'amount' => 6154, 'wording' => 'elit, sed do eiusmod', 'active' => 1, 'created_at' => '2014-04-15 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 415, 'wording' => 'tempor incididunt ut', 'active' => 1, 'created_at' => '2014-05-28 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 2, 'amount' => 1454, 'wording' => 'labore et dolore magna', 'active' => 1, 'created_at' => '2014-05-30 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 5145, 'wording' => 'aliqua. Ut enim ad', 'active' => 1, 'created_at' => '2014-06-18 21:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 5145, 'wording' => 'minim veniam, quis', 'active' => 1, 'created_at' => '2014-07-30 21:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 14, 'wording' => 'nostrud exercitation ullamco', 'active' => 1, 'created_at' => '2014-08-01 01:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 1515, 'wording' => 'laboris nisi ut', 'active' => 1, 'created_at' => '2014-08-01 02:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 3, 'amount' => 415, 'wording' => 'aliquip ex ea commodo', 'active' => 1, 'created_at' => '2014-08-01 03:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 415, 'wording' => 'consequat. Duis aute irure', 'active' => 1, 'created_at' => '2014-08-01 04:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 3, 'amount' => 1545, 'wording' => 'dolor in reprehenderit in', 'active' => 1, 'created_at' => '2014-08-01 05:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 15400, 'wording' => 'Dépot', 'active' => 1, 'created_at' => '2015-01-01 05:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 2, 'amount' => 154, 'wording' => 'Bons et loyaux services', 'active' => 1, 'created_at' => '2015-02-25 05:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 124, 'wording' => 'Lorem ipsum dolor sit', 'active' => 1, 'created_at' => '2015-02-22 05:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 4514, 'wording' => 'amet, consectetur adipisicing', 'active' => 1, 'created_at' => '2015-03-12 05:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 3, 'amount' => 6154, 'wording' => 'elit, sed do eiusmod', 'active' => 1, 'created_at' => '2015-04-15 05:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 415, 'wording' => 'tempor incididunt ut', 'active' => 1, 'created_at' => '2015-05-28 05:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 2, 'amount' => 1454, 'wording' => 'labore et dolore magna', 'active' => 1, 'created_at' => '2015-05-30 05:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 5145, 'wording' => 'aliqua. Ut enim ad', 'active' => 1, 'created_at' => '2015-06-18 05:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 5145, 'wording' => 'minim veniam, quis', 'active' => 1, 'created_at' => '2015-07-30 21:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 14, 'wording' => 'nostrud exercitation ullamco', 'active' => 1, 'created_at' => '2015-08-01 01:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 1515, 'wording' => 'laboris nisi ut', 'active' => 1, 'created_at' => '2015-08-01 02:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 3, 'amount' => 415, 'wording' => 'aliquip ex ea commodo', 'active' => 1, 'created_at' => '2015-08-01 03:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 415, 'wording' => 'consequat. Duis aute irure', 'active' => 1, 'created_at' => '2015-08-01 04:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 3, 'amount' => 1545, 'wording' => 'dolor in reprehenderit in', 'active' => 1, 'created_at' => '2015-08-01 05:52:35'),
            ));

        DB::table('posts')->insert(
            array(
                array('user_id' => 2, 'category' => 'general', 'body' => 'Site en cours de développement, de nouvelles fonctionnalités arriveront au fûr et à mesure.', 'created_at' => Carbon::now()->subMinutes(154), 'updated_at' => Carbon::now()->subMinutes(154)),
            ));

        DB::commit();

        Model::reguard();
    }
}
