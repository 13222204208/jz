<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BgRotationChart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bg_rotation_chart', function (Blueprint $table) {//应用轮播图
            $table->increments('id');
            $table->string('img_url',200)->default('')->comment('图片链接及路径');
            $table->string('jump_url',200)->default('')->comment('跳转的链接');
            $table->string('title',20)->default('')->comment('标题');
            $table->integer('img_sort')->default(1)->comment('图片显示排序');
            $table->integer('state')->default(1)->comment('轮播图状态 1 为开启 0为关闭');
            $table->integer('url_type')->default(1)->comment('默认为广告类型');
            $table->timestamps();
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
