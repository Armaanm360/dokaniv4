<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transfer', function (Blueprint $table) {
            $table->increments('account_transfer_id');
            $table->integer('account_from');
            $table->integer('account_to');
            $table->integer('account_transaction_id')->nullable();
            $table->integer('amount');
            $table->string('date');
            $table->string('note')->nullable();
            $table->string('created_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('status')->nullable();
            $table->string('has_deleted')->default("NO");
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
        Schema::dropIfExists('account_transfer');
    }
}
