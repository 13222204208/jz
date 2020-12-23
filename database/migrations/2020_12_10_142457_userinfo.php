<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Userinfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userinfo', function (Blueprint $table) {
            $table->id();
            $table->string('username')->default('')->comment('用户名');
            $table->string('password')->default('')->comment('密码');
            $table->string('wx_id')->unique()->comment('微信号');
            $table->string('wx_session_key')->unique()->comment('微信的session_key');
            $table->string('phone',11)->default(0)->comment('手机号');
            $table->string('nickname')->default('')->comment('用户昵称');
            $table->tinyInteger('sex')->default(0)->comment('性别 0代表女，1代表男');
            $table->string('address')->default('')->comment('地址');
            $table->tinyInteger('role_id')->default(1)->comment('角色 1,业主 2,商家 3,工程师');
            $table->string('role')->default('')->comment('角色名称');
            $table->string('cover')->default('')->comment('头像');
            $table->string('company')->default('')->comment('公司');
            $table->string('truename')->default('')->comment('真实姓名');
            $table->string('id_number',18)->default('')->comment('身份证号');
            $table->string('id_front')->default('')->comment('身份证正面');
            $table->string('id_the_back')->default('')->comment('身份反面');
            $table->string('id_in_hand')->default('')->comment('手持身份证');
            $table->tinyInteger('engineer_status')->default(2)->comment('安装师傅状态，2为未审核，1为审核通过');
            $table->timestamps();

            $table->comment="小程序登陆的用户表";
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
