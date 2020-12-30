<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FinishConstructions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finish_constructions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_num')->unique()->comment('工程订单号');
            $table->string('photo')->comment('施工完成图片');
            $table->string('comments')->nullable()->comment('备注');
            $table->timestamps();
            $table->comment="订单施工完成";
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
