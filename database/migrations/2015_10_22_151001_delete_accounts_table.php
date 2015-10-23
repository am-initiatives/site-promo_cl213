<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('accounts');

        Schema::table('transactions', function($table)
        {
            $table->renameColumn('credited_account_id', 'credited_user_id');
            $table->renameColumn('debited_account_id', 'debited_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function($table)
        {
            $table->renameColumn('credited_user_id', 'credited_account_id');
            $table->renameColumn('debited_user_id', 'debited_account_id');
        });
        
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('description', 100);
            $table->boolean('restricted')->default(1);
            $table->boolean('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }
}
