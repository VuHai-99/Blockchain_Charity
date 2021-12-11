<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableOrderReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_receipts', function (Blueprint $table) {
            $table->dropPrimary('order_id');
            $table->string('donation_activity_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_receipts', function (Blueprint $table) {
            $table->dropColumn('donation_activity_address');
        });
    }
}