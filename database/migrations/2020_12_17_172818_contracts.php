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
            $table->string('cover')->default('')->comment('合同封面图');
            $table->string('file_name')->default('')->comment('合同文件');
            $table->string('first_name')->nullable()->comment('甲方抬头');
            $table->string('second_name')->nullable()->comment('乙方抬头');
            $table->string('contract_num')->nullable()->comment('合同编号');
            $table->decimal('amount_completed',11,2)->default(0)->comment('完成数量金额');
            $table->decimal('return_amount',11,2)->default(0)->comment('返回套数金额');
            $table->decimal('amplification_amount',11,2)->default(0)->comment('扩增销售金额');
            $table->string('start_time')->default('')->comment('合同开始时间');
            $table->string('stop_time')->default('')->comment('合同结束时间');
            $table->string('comments')->default('')->comment('合同备注');
            $table->decimal('cost',11,2)->default(0)->comment('合同费用');
            $table->integer('quantity')->default(1)->comment('合同套数');
            $table->integer('done_quantity')->default(0)->comment('已完成合同套数');
            $table->integer('status')->default(1)->comment('合同状态  1：进行中  2：已完成');
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
