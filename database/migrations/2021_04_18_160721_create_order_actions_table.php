<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable()->comment('id don hang');
            $table->timestamp('created_datetime')->nullable()->comment('thoi gian tao');
            $table->integer('created_user_id')->nullable()->comment('id nguoi tao don hang');
            $table->timestamp('received_datetime')->nullable()->comment('thoi gian admin tiep nhan don hang');
            $table->integer('received_user_id')->nullable()->comment('id admin nhan don hang');
            $table->timestamp('deposited_datetime')->nullable()->comment('thoi gian dat coc');
            $table->integer('deposited_user_id')->nullable()->comment('id admin vao tien dat coc don hang');
            $table->timestamp('successed_datetime')->nullable()->comment('thoi gian hoan thanh don');
            $table->integer('successed_user_id')->nullable()->comment('id admin xac nhan don hoan thanh');
            $table->timestamp('cancled_datetime')->nullable()->comment('ngay huy don hang');
            $table->integer('cancled_user_id')->nullable()->comment('id admin huy don hang');
            $table->string('cancle_reason')->nullable()->comment('ly do huy don hang');
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
        Schema::dropIfExists('order_actions');
    }
}
