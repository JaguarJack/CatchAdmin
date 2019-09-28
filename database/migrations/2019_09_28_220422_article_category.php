<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticleCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('article_category', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('pid')->nullable(false)->default(0)->comment('父级ID');
            $table->string('name')->default(false)->comment('分类名称');
            $table->string('level')->default('')->comment('层级关系');
            $table->smallInteger('sub_amount')->default(0)->comment('子级数量');
            $table->smallInteger('article_amount')->default(0)->comment('文章数量');
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
