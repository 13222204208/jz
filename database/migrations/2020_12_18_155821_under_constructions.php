<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnderConstructions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('under_constructions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_num')->comment('工程订单号');
            $table->string('photo')->comment('施工前图片');
            $table->string('comments')->nullable()->comment('备注');
            $table->timestamps();
            $table->comment="订单施工中";
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
