<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GoodsPackage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_package', function (Blueprint $table) {//套餐表
            $table->id();
            $table->string('title',200)->default('')->comment('套餐名');
            $table->string('description',200)->default('')->comment('套餐描述');
            $table->string('cover')->default('')->comment('套餐封面图');
            $table->string('photo')->default('')->comment('产品轮播图片');
            $table->decimal('price',11,2)->default(0)->comment('套餐价格');
            $table->decimal('package_price',11,2)->default(0)->comment('套餐单价');
            $table->text('content')->nullable()->comment('套餐详情介绍');
            $table->integer('status')->default(1)->comment('状态  1：上架  2：下架');
            $table->string('delete_time')->default('')->comment('删除时间');
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
