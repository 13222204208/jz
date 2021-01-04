<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuildBetweenGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_between_goods', function (Blueprint $table) {//套餐和商品的中间表
            $table->id();
            $table->unsignedInteger('build_order_id')->comment('工程订单id');
            $table->unsignedInteger('goods_id')->comment('商品id');
            $table->unsignedInteger('quantity')->default(1)->comment('数量');
            $table->timestamps();

            $table->comment="工程订单和商品的中间表";
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
