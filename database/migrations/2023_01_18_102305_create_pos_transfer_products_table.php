<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTransferProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_transfer_products', function (Blueprint $table) {
            $table->increments('transfer_product_id');
            $table->longText('transferNo')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->string('create_date')->nullable();
            $table->string('has_deleted')->default('NO');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('pos_transfer_products');
    }
}
