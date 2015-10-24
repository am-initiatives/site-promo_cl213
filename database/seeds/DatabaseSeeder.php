<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use Ramsey\Uuid\Uuid;

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

        $users = $this->call(UserSeeder::class);
        $uuid = Uuid::uuid4()->toString();

        DB::table('transactions')->insert(
            array(
                array('credited_user_id' => 2, 'debited_user_id' => 1, 'amount' => 15400, 'wording' => 'Dépot', 'active' => 1, 'created_at' => '2014-01-01 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 2, 'amount' => 154, 'wording' => 'Bons et loyaux services', 'active' => 1, 'created_at' => '2014-02-25 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 1, 'amount' => 124, 'wording' => 'Lorem ipsum dolor sit', 'active' => 1, 'created_at' => '2014-02-22 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 1, 'debited_user_id' => 2, 'amount' => 4514, 'wording' => 'amet, consectetur adipisicing', 'active' => 1, 'created_at' => '2014-03-12 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 3, 'amount' => 6154, 'wording' => 'elit, sed do eiusmod', 'active' => 1, 'created_at' => '2014-04-15 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 1, 'amount' => 415, 'wording' => 'tempor incididunt ut', 'active' => 1, 'created_at' => '2014-05-28 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 2, 'amount' => 1454, 'wording' => 'labore et dolore magna', 'active' => 1, 'created_at' => '2014-05-30 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 1, 'amount' => 5145, 'wording' => 'aliqua. Ut enim ad', 'active' => 1, 'created_at' => '2014-06-18 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 1, 'amount' => 5145, 'wording' => 'minim veniam, quis', 'active' => 1, 'created_at' => '2014-07-30 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 1, 'debited_user_id' => 3, 'amount' => 14, 'wording' => 'laboris nisi ut', 'active' => 1, 'created_at' => '2014-08-01 01:52:35','state'=>"pending",'group_id'=>$uuid),
                array('credited_user_id' => 1, 'debited_user_id' => 2, 'amount' => 14, 'wording' => 'laboris nisi ut', 'active' => 1, 'created_at' => '2014-08-01 02:52:35','state'=>"pending",'group_id'=>$uuid),
                array('credited_user_id' => 1, 'debited_user_id' => 3, 'amount' => 415, 'wording' => 'aliquip ex ea commodo', 'active' => 1, 'created_at' => '2014-08-01 03:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 1, 'amount' => 415, 'wording' => 'consequat. Duis aute irure', 'active' => 1, 'created_at' => '2014-08-01 04:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 3, 'amount' => 1545, 'wording' => 'dolor in reprehenderit in', 'active' => 1, 'created_at' => '2014-08-01 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 1, 'amount' => 15400, 'wording' => 'Dépot', 'active' => 1, 'created_at' => '2015-01-01 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 2, 'amount' => 154, 'wording' => 'Bons et loyaux services', 'active' => 1, 'created_at' => '2015-02-25 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 1, 'amount' => 124, 'wording' => 'Lorem ipsum dolor sit', 'active' => 1, 'created_at' => '2015-02-22 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 1, 'debited_user_id' => 2, 'amount' => 4514, 'wording' => 'amet, consectetur adipisicing', 'active' => 1, 'created_at' => '2015-03-12 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 3, 'amount' => 6154, 'wording' => 'elit, sed do eiusmod', 'active' => 1, 'created_at' => '2015-04-15 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 1, 'amount' => 415, 'wording' => 'tempor incididunt ut', 'active' => 1, 'created_at' => '2015-05-28 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 2, 'amount' => 1454, 'wording' => 'labore et dolore magna', 'active' => 1, 'created_at' => '2015-05-30 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 1, 'amount' => 5145, 'wording' => 'aliqua. Ut enim ad', 'active' => 1, 'created_at' => '2015-06-18 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 1, 'amount' => 5145, 'wording' => 'minim veniam, quis', 'active' => 1, 'created_at' => '2015-07-30 21:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 1, 'debited_user_id' => 2, 'amount' => 14, 'wording' => 'nostrud exercitation ullamco', 'active' => 1, 'created_at' => '2015-08-01 01:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 1, 'debited_user_id' => 2, 'amount' => 1515, 'wording' => 'laboris nisi ut', 'active' => 1, 'created_at' => '2015-08-01 02:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 1, 'debited_user_id' => 3, 'amount' => 415, 'wording' => 'aliquip ex ea commodo', 'active' => 1, 'created_at' => '2015-08-01 03:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 3, 'debited_user_id' => 1, 'amount' => 415, 'wording' => 'consequat. Duis aute irure', 'active' => 1, 'created_at' => '2015-08-01 04:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
                array('credited_user_id' => 2, 'debited_user_id' => 3, 'amount' => 1545, 'wording' => 'dolor in reprehenderit in', 'active' => 1, 'created_at' => '2015-08-01 05:52:35','state'=>"pending",'group_id'=>Uuid::uuid4()->toString()),
            ));

        DB::table('posts')->insert(
            array(
                array('user_id' => 2, 'category' => 'general', 'body' => 'Site en cours de développement, de nouvelles fonctionnalités arriveront au fûr et à mesure.', 'created_at' => Carbon::now()->subMinutes(154), 'updated_at' => Carbon::now()->subMinutes(154)),
            ));

        DB::commit();

        Model::reguard();
    }
}
