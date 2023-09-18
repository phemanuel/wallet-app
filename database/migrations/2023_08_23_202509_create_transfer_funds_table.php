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
        Schema::create('transfer_funds', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_account_id');
            $table->integer('reciever_account_id');
            $table->string('sender_email');
            $table->string('reciever_email');
            $table->string('sender_full_name');
            $table->string('reciever_full_name');
            $table->string('sender_phone_no');
            $table->string('reciever_phone_no');
            $table->string('sender_wallet_id');
            $table->string('reciever_wallet_id');
            $table->string('transaction_type');
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_funds');
    }
};
