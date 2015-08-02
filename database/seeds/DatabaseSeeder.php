<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        DB::table('users')->insert(
            array(
                array('username' => 'admin', 'password' => '$2y$10$AX84e0sgeXDoiiskAxhHXuSLonGlGyowjuyGm08BlLA/U484LCdKy', 'email' => 'corentin.gitton@gadz.org', 'google_id' => NULL, 'given_name' => 'Corentin', 'family_name' => 'GITTON', 'nickname' => 'Tarmak 154', 'information' => '[]', 'active' => 1, 'permissions' => '[]'),
                array('username' => 'user', 'password' => '$2y$10$AX84e0sgeXDoiiskAxhHXuSLonGlGyowjuyGm08BlLA/U484LCdKy', 'email' => 'corentin.gitton@gamil.com', 'google_id' => NULL, 'given_name' => 'User', 'family_name' => 'RANDOM', 'nickname' => 'User', 'information' => '[]', 'active' => 0, 'permissions' => '[]'),
            ));

        DB::table('accounts')->insert(
            array(
                array('user_id' => NULL, 'description' => 'Compte de Prom\'sss', 'restricted' => 0, 'active' => 1),
                array('user_id' => 1, 'description' => 'Compte de Tarmak 154', 'restricted' => 1, 'active' => 1),
                array('user_id' => 2, 'description' => 'Compte de User', 'restricted' => 1, 'active' => 1),
            ));

        DB::table('transactions')->insert(
            array(
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 15400, 'wording' => 'Dépot', 'active' => 1, 'created_at' => '2015-01-01 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 2, 'amount' => 154, 'wording' => 'Bons et loyaux services', 'active' => 1, 'created_at' => '2015-02-25 21:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 124, 'wording' => 'Lorem ipsum dolor sit', 'active' => 1, 'created_at' => '2015-02-22 21:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 4514, 'wording' => 'amet, consectetur adipisicing', 'active' => 1, 'created_at' => '2015-03-12 21:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 3, 'amount' => 6154, 'wording' => 'elit, sed do eiusmod', 'active' => 1, 'created_at' => '2015-04-15 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 415, 'wording' => 'tempor incididunt ut', 'active' => 1, 'created_at' => '2015-05-28 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 2, 'amount' => 1454, 'wording' => 'labore et dolore magna', 'active' => 1, 'created_at' => '2015-05-30 21:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 5145, 'wording' => 'aliqua. Ut enim ad', 'active' => 1, 'created_at' => '2015-06-18 21:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 1, 'amount' => 5145, 'wording' => 'minim veniam, quis', 'active' => 1, 'created_at' => '2015-07-30 21:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 14, 'wording' => 'nostrud exercitation ullamco', 'active' => 1, 'created_at' => '2015-08-01 01:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 2, 'amount' => 1515, 'wording' => 'laboris nisi ut', 'active' => 1, 'created_at' => '2015-08-01 02:52:35'),
                array('credited_account_id' => 1, 'debited_account_id' => 3, 'amount' => 415, 'wording' => 'aliquip ex ea commodo', 'active' => 1, 'created_at' => '2015-08-01 03:52:35'),
                array('credited_account_id' => 3, 'debited_account_id' => 1, 'amount' => 415, 'wording' => 'consequat. Duis aute irure', 'active' => 1, 'created_at' => '2015-08-01 04:52:35'),
                array('credited_account_id' => 2, 'debited_account_id' => 3, 'amount' => 1545, 'wording' => 'dolor in reprehenderit in', 'active' => 1, 'created_at' => '2015-08-01 05:52:35'),
            ));

        Model::reguard();
    }
}
