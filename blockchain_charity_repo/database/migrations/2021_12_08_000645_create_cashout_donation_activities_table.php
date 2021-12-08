<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashoutDonationActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashout_donation_activities', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('authority_confirmation');
            $table->string('cashout_amount');
            $table->string('donation_activity_address');
            $table->string('cashout_code');
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
        Schema::dropIfExists('cashout_donation_activities');
    }
}
