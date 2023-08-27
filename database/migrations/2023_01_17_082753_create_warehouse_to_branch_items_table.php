<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseToBranchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_to_branch_items', function (Blueprint $table) {
            $table->increments('warehouse_to_branch_items_id');
            $table->string('warehouse_to_branch_transfer_number')->nullable();
            $table->string('warehouse_to_branch_transfer_id')->nullable();
            $table->string('transfer_product_id')->nullable();
            $table->string('transfer_product_available_balance')->nullable();
            $table->string('transfer_product_amount')->nullable();
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
        Schema::dropIfExists('warehouse_to_branch_items');
    }
}
