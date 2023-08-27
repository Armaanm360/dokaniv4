<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMoneyReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('money_receipt', function (Blueprint $table) {
           $table->integer("money_receipt_invoice_no")->nullable()->after('money_receipt_voucher_no');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('money_receipt', function (Blueprint $table) {
            //
        });
    }
}
