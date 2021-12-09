<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRetailerAddressTableOrderReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_receipts', function (Blueprint $table) {
            $table->string('retailer_address')->after('total_receipt');
            $table->string('host_address')->after('total_receipt');
            $table->string('date_of_payment')->nullable()->change();
            $table->dropColumn('deleted_at');
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
            $table->dropColumn('retailer_address');
            $table->dropColumn('host_address');
            $table->softDeletes();
        });
    }
}