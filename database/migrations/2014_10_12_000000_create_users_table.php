<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone_no');
            $table->string('user_name');
            $table->string('gender');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('wallet_id');
            $table->double('wallet_balance');
            $table->double('total_money_spent');
            $table->double('total_money_transfer');
            $table->double('total_money_recieved');
            $table->dateTime('register_date');
            $table->string('std_no');
            $table->string('std_course');
            $table->string('profile_picture');
            $table->integer('account_status');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
