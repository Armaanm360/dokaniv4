<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnSaleIsDeleteToInvoiceReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_returns', function (Blueprint $table) {
            $table->string('return_sale_is_delete')->default('NO')->after('return_charge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_returns', function (Blueprint $table) {
            $table->dropColumn(['return_sale_is_delete']);
        });
    }
}
