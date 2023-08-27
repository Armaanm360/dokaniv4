<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_men', function (Blueprint $table) {
            $table->increments('delivery_men_id');
            $table->string('delivery_men_name')->nullable();
            $table->string('delivery_men_entry_id')->nullable();
            $table->string('delivery_men_phone_number')->nullable();
            $table->longText('delivery_men_address')->nullable();
            $table->string('delivery_men_status')->default(1);
            $table->string('delivery_men_is_deleted')->default('NO');
            $table->bigInteger('delivery_men_vehicle')->nullable();
            $table->string('delivery_men_created_by')->nullable();
            $table->string('delivery_men_updated_by')->nullable();
            $table->string('delivery_men_deleted_by')->nullable();
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
        Schema::dropIfExists('delivery_men');
    }
}
