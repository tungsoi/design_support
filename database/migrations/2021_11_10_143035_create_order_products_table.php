<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable();
            $table->text('link')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->integer('quality')->nullable()->default(0);
            $table->integer('price')->nullable()->default(0);
            $table->integer('amount')->nullable()->default(0);
            $table->integer('status')->nullable()->default(1);
            $table->text('note')->nullable();
            $table->text('transport_code')->nullable();
            $table->text('payment_code')->nullable();
            $table->integer('payment_type')->nullable()->default(0); // 0 kg, 1 khoi
            $table->double('value_use_payment')->nullable()->default(0);
            $table->integer('service_price')->nullable()->default(0);
            $table->integer('payment_amount')->nullable()->default(0);
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
        Schema::dropIfExists('order_products');
    }
}
