<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DoneConstructions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('done_constructions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_num')->unique()->comment('工程订单号');
            $table->string('owner_sign_photo')->comment('业主签字图片');
            $table->string('engineer_sign_photo')->comment('工程师签字图片');
            $table->timestamps();
            $table->comment="订单施工完成 ";
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
