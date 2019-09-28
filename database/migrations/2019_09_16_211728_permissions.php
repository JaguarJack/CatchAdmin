<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Permissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->default(0)->comment('父级ID');
            $table->string('name')->comment('菜单名称');
            $table->string('level')->default('')->comment('菜单层级');
            $table->string('alias')->default('')->comment('菜单别名');
            $table->string('route')->comment('路由名称');
            $table->string('method')->comment('HTTP METHOD');
            $table->string('path')->comment('前端使用的路由路径');
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
        Schema::dropIfExists('admin_permissions');
    }
}
