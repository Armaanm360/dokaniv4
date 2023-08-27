<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePosSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_pos_sales', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->bigInteger('invoice_no')->nullable();
            $table->string('sales_form')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('staff_id')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('sales_date')->nullable();
            $table->bigInteger('subTotal')->nullable();
            $table->bigInteger('product_discount')->nullable();
            $table->bigInteger('vat_rate')->nullable();
            $table->bigInteger('vat_amount')->nullable();
            $table->bigInteger('overall_discount')->nullable();
            $table->bigInteger('grand_total')->nullable();
            $table->bigInteger('payment_type')->nullable();
            $table->bigInteger('account')->nullable();
            $table->bigInteger('total_paying')->nullable();
            $table->bigInteger('change')->nullable();
            $table->string('invoice_create_date')->nullable();
            $table->string('invoice_has_deleted')->default('NO');
            $table->bigInteger('invoice_created_by')->nullable();
            $table->string('invoice_deleted_by')->nullable();
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
        Schema::dropIfExists('invoice_pos_sales');
    }
}
