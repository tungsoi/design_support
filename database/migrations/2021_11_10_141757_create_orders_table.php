<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->nullable();
            $table->integer('amount_products_price')->nullable()->default(0);
            $table->integer('default_deposite')->nullable()->default(0);
            $table->integer('amount_ship_service')->nullable()->default(0);
            $table->integer('amount_other_service')->nullable()->default(0);
            $table->integer('deposited')->nullable()->default(0);
            $table->integer('is_discount')->nullable()->default(0);
            $table->integer('type_discount')->nullable()->default(0);
            $table->integer('discount_value')->nullable()->default(0);
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
        Schema::dropIfExists('orders');
    }
}
