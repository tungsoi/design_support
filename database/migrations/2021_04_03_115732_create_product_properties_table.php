<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->nullable()->comment('id san pham');
            $table->string('size')->nullable()->comment('Mã kích thước');
            $table->string('lenght')->nullable()->comment('Chieu dai');
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->integer('material_id')->nullable()->comment('Mã vật liệu');
            $table->string('price')->nullable();
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
        Schema::dropIfExists('product_properties');
    }
}
