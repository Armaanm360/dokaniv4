<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('account_id');
            $table->string('account_name')->nullable();
            $table->string('account_type')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->string('account_bank_name')->nullable();
            $table->string('account_branch_name')->nullable();
            $table->string('account_balance')->nullable();
            $table->bigInteger('account_status')->nullable();
            $table->string('account_create_date')->nullable();
            $table->string('account_has_deleted')->default('NO');
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
        Schema::dropIfExists('accounts');
    }
}
