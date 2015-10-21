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
        DB::beginTransaction();

        $test = $this->call(UserSeeder::class);

        $test->each()->delete();

        return true;

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
