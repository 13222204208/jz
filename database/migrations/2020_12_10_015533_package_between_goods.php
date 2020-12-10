<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PackageBetweenGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_between_goods', function (Blueprint $table) {//套餐和商品的中间表
            $table->id();
            $table->unsignedInteger('goods_package_id')->comment('套餐id');
            $table->unsignedInteger('goods_id')->comment('商品id');

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
