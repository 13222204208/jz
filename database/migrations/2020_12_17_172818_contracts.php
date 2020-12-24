<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id')->default(0)->comment('商家的id');
            $table->string('title',200)->default('')->comment('合同的名称');
            //$table->json('accessory')->nullable()->comment('合同的附件');
            $table->string('cover')->default('')->comment('合同封面图');
            $table->string('file_name')->default('')->comment('合同文件');
            $table->string('start_time')->default('')->comment('合同开始时间');
            $table->string('stop_time')->default('')->comment('合同结束时间');
            $table->string('comments')->default('')->comment('合同备注');
            $table->decimal('cost',11,2)->default(0)->comment('合同费用');
            $table->integer('quantity')->default(1)->comment('合同套数');
            $table->integer('status')->default(1)->comment('合同状态  1：开启  2：关闭');
            $table->string('delete_time')->default('')->comment('删除时间');
            $table->timestamps();
            $table->comment="平台与商家的合同";
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
