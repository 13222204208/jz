<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Collects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collects', function (Blueprint $table) {//套餐和商品的中间表
            $table->id();
            $table->unsignedInteger('userinfo_id')->comment('用户id');
            $table->unsignedInteger('goods_id')->comment('商品id');
            $table->string('comments')->default('')->comment('备注');
            $table->decimal('price',11,2)->default(0)->comment('价格');
            $table->unsignedInteger('quantity')->default(1)->comment('数量');
            $table->unsignedInteger('status')->default(1)->comment('1,收藏列表,2方案中');

            $table->timestamps();

            $table->comment="用户和商品的中间表 自定义套餐表";
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
