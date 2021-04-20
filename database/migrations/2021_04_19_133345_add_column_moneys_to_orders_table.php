<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMoneysToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('total_item_amount')->nullable()->comment('tong tien san pham');
            $table->string('discount_amount')->nullable()->comment('tien discount giam gia');
            $table->string('discount_reason')->nullable()->comment('ly do giam gia');
            $table->string('other_amount')->nullable()->comment('tien phat sinh khac');
            $table->string('final_amount')->nullable()->comment('tong tien don hang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_item_amount');
            $table->dropColumn('discount_amount');
            $table->dropColumn('discount_reason');
            $table->dropColumn('other_amount');
            $table->dropColumn('final_amount');
        });
    }
}
