<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AfterSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_sale', function (Blueprint $table) {//报修和售后表
            $table->id();
            $table->unsignedInteger('user_id')->comment('业主id');
            $table->unsignedInteger('bo_id')->default(0)->comment('施工订单id');
            $table->unsignedInteger('bov_id')->default(0)->comment('施工订单中的某个产品id');
            $table->string('goods_name')->comment('产品名称');
            $table->string('hitch_content')->comment('故障描述');
            $table->string('photo')->default('')->comment('故障产品图片');
            $table->integer('status')->default(1)->comment('状态  1：待处理  2：处理中 3：完成');
            $table->string('delete_time')->default('')->comment('删除时间');
            $table->timestamps();

            $table->comment="业务报修和售后表";
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
