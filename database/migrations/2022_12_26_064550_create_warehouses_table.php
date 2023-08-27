<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments('warehouse_id');
            $table->string('warehouse_name')->nullable();
            $table->string('warehouse_entry_id')->nullable();
            $table->string('warehouse_phone_number')->nullable();
            $table->longText('warehouse_address')->nullable();
            $table->string('warehouse_status')->default(1);
            $table->string('warehouse_is_deleted')->default('NO');
            $table->string('warehouse_created_by')->nullable();
            $table->string('warehouse_updated_by')->nullable();
            $table->string('warehouse_deleted_by')->nullable();
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
        Schema::dropIfExists('warehouses');
    }
}
