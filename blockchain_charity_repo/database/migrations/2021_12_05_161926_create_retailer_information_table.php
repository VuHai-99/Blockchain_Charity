<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_information', function (Blueprint $table) {
            $table->string('retail_address')->primary();
            $table->string('retail_name');
            $table->string('email');
            $table->string('password');
            $table->string('brief_infor')->nullable();
            $table->string('hot_line');
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
        Schema::dropIfExists('retailer_information');
    }
}