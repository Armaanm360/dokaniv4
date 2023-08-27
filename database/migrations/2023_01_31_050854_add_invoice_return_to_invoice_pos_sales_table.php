<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceReturnToInvoicePosSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_pos_sales', function (Blueprint $table) {
            $table->string('invoice_return')->default('NO')->after('change');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_pos_sales', function (Blueprint $table) {
            $table->dropColumn(['invoice_return']);
        });
    }
}
