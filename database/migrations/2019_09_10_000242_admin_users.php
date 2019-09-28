<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar')->default('https://cdn.learnku.com/uploads/avatars/18206_1524645293.gif!/both/400x400');
            $table->string('introduction')->default('后台用户');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            createTableTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('admin_users');
    }
}
