<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Designs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('house_type')->default('')->comment('户型');
            $table->string('goods_type')->default('')->comment('类型');
            $table->string('phone')->default('')->comment('手机号');
            $table->unsignedInteger('cs_id')->default(0)->comment('客服id');
            $table->unsignedInteger('status')->default(1)->comment('状态，1，未处理，2已处理');
            $table->string('comments')->default('')->comment('备注');
            $table->timestamps();
            
            $table->comment="智能设计表";
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
