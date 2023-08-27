<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_to_branches', function (Blueprint $table) {
            $table->increments('warehouse_to_branch_transfer_id');
            $table->string('warehouse_to_branch_transfer_number')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('total_transfer_quantity')->nullable();
            $table->string('transfer_note')->nullable();
            $table->string('transfer_date')->nullable();
            $table->string('warehouse_to_branch_transfer_status')->default(1);
            $table->string('warehouse_to_branch_transfer_is_deleted')->default('NO');
            $table->string('warehouse_to_branch_transfer_created_by')->nullable();
            $table->string('warehouse_to_branch_transfer_updated_by')->nullable();
            $table->string('warehouse_to_branch_transfer_deleted_by')->nullable();
            $table->string('warehouse_to_branch_transfer_created_at')->nullable();
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
        Schema::dropIfExists('warehouse_to_branches');
    }
}
