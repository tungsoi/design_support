<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable()->comment('id don hang');
            $table->integer('product_id')->nullable()->comment('id san pham');
            $table->integer('product_property_id')->nullable()->comment('id kich thuoc');
            $table->integer('product_color_id')->nullable()->comment('id mau sac');
            $table->integer('order_qty')->nullable()->default(1)->comment('so luong dat mua tren don');
            $table->integer('reality_qty')->nullable()->default(1)->comment('so luong thuc dat');
            $table->string('price')->nullable()->comment('gia san pham theo don');
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
        Schema::dropIfExists('order_items');
    }
}
