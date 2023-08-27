<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceReturnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_return_products', function (Blueprint $table) {
            $table->increments('return_id');
            $table->bigInteger('return_sale_id')->null();
            $table->bigInteger('return_product_id')->null();
            $table->bigInteger('return_product_quantity')->null();
            $table->string('create_date')->null();
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
        Schema::dropIfExists('invoice_return_products');
    }
}
