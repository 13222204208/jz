<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userinfo_id')->default(0)->comment('用户id');
            $table->string('userinfo_phone')->comment('用户手机号');
            $table->string('order_num')->comment('订单号');
            $table->unsignedInteger('order_id')->default(0)->comment('订单id');
            $table->unsignedInteger('order_status')->default(0)->comment('订单状态 1，待施工，2施工中，3施工完成 ，4施工完成');
            $table->string('comments')->default('')->comment('备注');
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
        Schema::dropIfExists('table_news');
    }
}
