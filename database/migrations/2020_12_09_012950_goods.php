<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Goods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {//产品表
            $table->increments('id');
            $table->string('title',200)->default('')->comment('产品名');
            $table->string('description',200)->default('')->comment('描述');
            $table->string('cover')->default('')->comment('产品封面图');
            $table->string('photo')->default('')->comment('产品轮播图片');
            $table->integer('number')->default(0)->comment('数量库存');
            $table->decimal('price',11,2)->default(0)->comment('单价');
            $table->decimal('package_price',11,2)->default(0)->comment('套餐单价');
            $table->integer('sales_volume')->default(0)->comment('真实销售数量（前台展示销量 需要加上虚拟销量');
            $table->integer('fake_sales_volume')->default(1)->comment('虚拟销售数量');
            $table->text('content')->nullable()->comment('详情介绍');
            $table->integer('status')->default(1)->comment('状态  1：上架  2：下架');
            $table->string('delete_time')->default('')->comment('删除时间');
            $table->timestamps();
            $table->comment="产品表";
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
