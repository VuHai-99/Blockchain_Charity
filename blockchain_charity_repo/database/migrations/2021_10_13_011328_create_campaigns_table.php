<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->string('campaign_address')->primary();
            $table->string('name')->nullable();
            $table->string('host_address');
            $table->text('description')->nullable();
            $table->string('minimum_contribution');
            $table->string('target_contribution_amount')->nullable();
            $table->string('current_balance');
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
        Schema::dropIfExists('projects');
    }
}
