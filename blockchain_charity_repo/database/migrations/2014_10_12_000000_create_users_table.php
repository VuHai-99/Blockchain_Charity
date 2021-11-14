<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_address')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('home_address');
            $table->string('phone');
            $table->integer('wallet_type');
            $table->string('amount_of_money')->nullable();
            $table->integer('otp_code')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->integer('validate_state')->nullable();
            $table->string('private_key')->nullable();
            $table->string('image_card_front')->nullable();
            $table->string('image_card_back')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
