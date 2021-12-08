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
            $table->string('receipt_url');
            $table->string('retailer_address');
            $table->tinyInteger('order_state');
            $table->tinyInteger('authority_confirmation');
            $table->string('total_amount');
            $table->string('order_code');
            $table->string('donation_activity_address');
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
        Schema::dropIfExists('order_donation_activities');
    }
}