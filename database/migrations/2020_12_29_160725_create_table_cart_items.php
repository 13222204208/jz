<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCartItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id');
            $table->integer('product_id');
            $table->string('comments')->default('')->comment('备注');
            $table->decimal('price',11,2)->default(0)->comment('价格');
            $table->unsignedInteger('quantity')->default(1)->comment('数量');
            $table->unsignedInteger('status')->default(1)->comment('1,收藏列表,2方案中');
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
        Schema::dropIfExists('table_carts_item');
    }
}
