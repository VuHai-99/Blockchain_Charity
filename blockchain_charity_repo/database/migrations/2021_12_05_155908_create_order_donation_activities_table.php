<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDonationActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_donation_activities', function (Blueprint $table) {
            $table->id();
            $table->string('recipt_url');
            $table->string('retailer_address');
            $table->tinyInteger('order_state');
            $table->tinyInteger('authority_confirmation');
            $table->string('total_amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_donation_activities');
    }
}