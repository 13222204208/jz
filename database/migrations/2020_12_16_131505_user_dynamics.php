<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserDynamics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_dynamics', function (Blueprint $table) {//报修和售后表
            $table->id();
            $table->unsignedInteger('user_id')->comment('业主id');
            $table->string('title')->default('')->comment('标题');
            $table->string('photo')->comment('美图图片');
            $table->integer('status')->default(1)->comment('状态  1：待审核  2：审核通过 3：审核未通过');
            $table->string('delete_time')->default('')->comment('删除时间');
            $table->timestamps();

            $table->comment="业主发布的美图";
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
