<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('supplier_id')->nullable()->comment('nha cung cap');
            $table->text('link_3d')->nullable()->comment('link san pham 3d');
            $table->integer('quantity_sold')->nullable()->default(0)->comment('Số lượng sản phẩm này đã bán');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
            $table->dropColumn('link_3d');
            $table->dropColumn('quantity_sold');
        });
    }
}
