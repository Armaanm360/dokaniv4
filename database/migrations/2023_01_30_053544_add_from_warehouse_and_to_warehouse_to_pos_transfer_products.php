<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromWarehouseAndToWarehouseToPosTransferProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_transfer_products', function (Blueprint $table) {
            $table->bigInteger('from_warehouse')->nullable()->after('quantity');
            $table->bigInteger('to_warehouse')->nullable()->after('from_warehouse');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_transfer_products', function (Blueprint $table) {
            $table->dropColumn(['from_warehouse', 'to_warehouse']);
        });
    }
}
