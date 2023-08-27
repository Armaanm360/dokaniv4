<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_transfers', function (Blueprint $table) {
            $table->increments('transfer_id');
            $table->string('transferDate')->nullable();
            $table->longText('transferNo')->nullable();
            $table->bigInteger('fromWarehouseID')->nullable();
            $table->bigInteger('toWarehouseID')->nullable();
            $table->longText('note')->nullable();
            $table->string('create_date')->nullable();
            $table->string('has_deleted')->default('NO');
            $table->bigInteger('created_by')->nullable();
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('pos_transfers');
    }
}
