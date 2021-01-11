<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CaseInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_infos', function (Blueprint $table) {//产品表
            $table->increments('id');
            $table->string('title',200)->default('')->comment('标题');
            $table->string('type',200)->default('')->comment('类型 case 代表案例 info代表资讯');
            $table->string('cover')->default('')->comment('封面图');
            $table->string('tag')->default('')->comment('案例标签');
            $table->string('photo')->default('')->comment('详情组图');
            $table->text('content')->default('')->comment('详情介绍');
            $table->integer('status')->default(1)->comment('状态  1：开启  2：关闭');
            $table->string('delete_time')->default('')->comment('删除时间');
            $table->timestamps();
            $table->comment="案例和资讯";
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
