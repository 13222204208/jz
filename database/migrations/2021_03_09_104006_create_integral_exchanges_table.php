<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegralExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('order_num')->nullable()->comment('订单号');
            $table->unsignedBigInteger('user_id')->comment('申请兑换积分的用户id');
            $table->unsignedBigInteger('integral')->comment('申请兑换积分的数量');
            $table->tinyInteger('status')->default(1)->comment('1，未审批，2审批通过，3拒绝');
            $table->string('examine')->nullable()->comment('审批帐号');
            $table->string('examine_time')->nullable()->comment('审批时间');
            $table->string('voucher')->nullable()->comment('凭证');
            $table->decimal('money',9,2)->default(0)->comment('兑换的金额');
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
        Schema::dropIfExists('integral_exchanges');
    }
}
