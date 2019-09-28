<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('category_id')->nullable(false)->comment('分类ID');
            $table->string('title')->nullable(false)->comment('文章标题');
            $table->text('content')->default(false)->comment('分类名称');
            $table->string('author')->default('')->comment('作者');
            $table->string('thumb_img')->default('')->comment('缩略图');
            $table->integer('pv')->default(0)->comment('默认的PV数量');
            $table->string('tags')->default('')->comment('标签');
            createTableTimestamps($table);
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table){
           $table->increments('id');
           $table->string('name')->nullable(false)->comment('标签名称');
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
    }
}
