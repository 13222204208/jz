<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contract_id')->default(0)->comment('合同id');
            $table->unsignedInteger('goods_package_id')->default(0)->comment('套餐id');
            $table->unsignedInteger('goods_package_qty')->default(0)->comment('套餐数量');
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
        Schema::dropIfExists('contract_packages');
    }
}
