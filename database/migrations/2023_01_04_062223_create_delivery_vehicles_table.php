<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_vehicles', function (Blueprint $table) {
            $table->increments('delivery_vehicles_id');
            $table->string('delivery_vehicles_name')->nullable();
            $table->string('delivery_vehicles_entry_id')->nullable();
            $table->string('delivery_vehicles_number')->nullable();
            $table->longText('delivery_vehicles_reg_no')->nullable();
            $table->string('delivery_vehicles_status')->default(1);
            $table->string('delivery_vehicles_is_deleted')->default('NO');
            $table->string('delivery_vehicles_created_by')->nullable();
            $table->string('delivery_vehicles_updated_by')->nullable();
            $table->string('delivery_vehicles_deleted_by')->nullable();
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
        Schema::dropIfExists('delivery_vehicles');
    }
}