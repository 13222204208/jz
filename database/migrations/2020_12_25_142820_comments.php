<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userinfo_id')->index()->comment('评论的用户id');
            $table->integer('user_dynamic_id')->index()->comment('美图的id');
            $table->integer('parent_id')->index()->nullable()->comment('有子评论使用');
            $table->text('content')->comment('评论内容');
            $table->timestamps();

            
            $table->comment="评论表";
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
