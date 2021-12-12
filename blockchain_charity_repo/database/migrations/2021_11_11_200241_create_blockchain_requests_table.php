<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_requests', function (Blueprint $table) {
            $table->string('request_id')->primary();
            $table->integer('request_type');
            $table->string('amount')->nullable();
            $table->string('requested_user_address');
            $table->string('campaign_address')->nullable();
            $table->string('campaign_name')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('target_contribution_amount')->nullable();
            $table->text('description')->nullable();
            $table->text('authority_address')->nullable();
            $table->string('donation_activity_address')->nullable();
            $table->string('url')->nullable();
            $table->string('retailer_address')->nullable();
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
        Schema::dropIfExists('blockchain_requests');
    }
}
