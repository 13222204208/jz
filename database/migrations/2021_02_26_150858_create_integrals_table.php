<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrals', function (Blueprint $table) {
            $table->id();
            $table->integer('engineer_parameter')->default(0)->comment('工程订单积分参数');
            $table->integer('owner_parameter')->default(0)->comment('客户订单积分参数');
            $table->timestamps();

            $table->comment="积分参数表";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integrals');
    }
}
