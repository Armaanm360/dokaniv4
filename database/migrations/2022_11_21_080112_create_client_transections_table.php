<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_transactions', function (Blueprint $table) {
            $table->increments('client_transaction_id');
            $table->string('client_transaction_type')->nullable();
            $table->bigInteger('client_transaction_account_id')->nullable();
            $table->bigInteger('client_transaction_client_id')->nullable();
            $table->string('client_transaction_amount')->nullable();
            $table->string('client_transaction_last_balance')->nullable();
            $table->bigInteger('client_transaction_opening_balance')->nullable();
            $table->string('client_transaction_date')->nullable();
            $table->string('client_transaction_note')->nullable();
            $table->string('client_transaction_create_date')->nullable();
            $table->string('client_transaction_has_deleted')->default('NO');
            $table->string('client_transaction_deleted_by');
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
        Schema::dropIfExists('client_transactions');
    }
}
