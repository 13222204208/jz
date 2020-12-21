<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuildOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('build_orders', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name')->default('')->comment('业主名称');
            $table->string('owner_phone')->default('')->comment('业主联系方式');
            $table->string('owner_address')->default('')->comment('业主地址');
            $table->unsignedInteger('build_goods_package_id')->default(0)->comment('套内详单对应的自定义套餐id,
            提供ABC三套预设的产品组合给装修公司快速选择，客户亦有可能在这个ABC套餐基础上增添设备，所以这个工程中的最终产品清单，用一个单独的表保存，简称为S表');
            $table->string('functionary')->default('')->comment('负责人');
            $table->string('functionary_phone',11)->comment('负责人手机号');
            $table->string('time')->default('')->comment('时间');
            $table->unsignedInteger('agreement_id')->default(0)->comment('合同，合同的id');
            $table->unsignedInteger('user_id')->default(0)->comment('业主的id，有可能业主不是小程序用户');
            $table->unsignedInteger('merchant_id')->default(0)->comment('商家的id');
            $table->unsignedInteger('engineer_id')->default(0)->comment('工程师的id');
            $table->string('owner_demand')->default('')->comment('业主要求');
            $table->decimal('total_money',2)->default(0)->comment('订单金额');
            $table->string('order_num')->unqiue()->comment('订单号');
            $table->string('start_work_time')->default('')->comment('开工的时间');
            $table->string('signature_pic')->default('')->comment('当定施工订单完成时，工程师会上传一张合同签字完工的图片');
            $table->tinyInteger('status')->default(1)->comment(' 1：待施工  2：施工中  3：已完成    4：已取消');
            $table->timestamps();

            $table->comment="工程订单表";
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
