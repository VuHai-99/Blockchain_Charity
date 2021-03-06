<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_activities', function (Blueprint $table) {
            $table->string('donation_activity_address')->primary();
            $table->string('campaign_address');
            $table->string('host_address');
            $table->string('authority_address');
            $table->text('donation_activity_description');
            $table->string('donation_activity_name');
            $table->datetime('date_start')->nullable();
            $table->datetime('date_end')->nullable();
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
        Schema::dropIfExists('donation_activities');
    }
}