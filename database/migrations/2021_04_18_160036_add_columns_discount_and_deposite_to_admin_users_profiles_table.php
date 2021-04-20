<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsDiscountAndDepositeToAdminUsersProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('discount_percent')->nullable()->default('0')->comment('% discount tren moi don hang');
            $table->string('min_deposite_percent')->nullable()->default('50')->comment('% dat coc tien don hang toi thieu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('discount_percent');
            $table->dropColumn('min_deposite_percent');
        });
    }
}
