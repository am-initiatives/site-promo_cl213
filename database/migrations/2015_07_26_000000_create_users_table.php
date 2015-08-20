<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 20)->unique();
            $table->string('password', 60);
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('google_id')->nullable()->unique();

            $table->string('given_name', 20);
            $table->string('last_name', 20);
            $table->string('nickname', 20);
            $table->text('information');
            
            $table->boolean('active');
            $table->boolean('hidden');
            $table->text('permissions');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
