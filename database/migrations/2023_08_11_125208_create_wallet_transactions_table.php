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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->string('wallet_id');
            $table->string('std_no');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_no')->nullable();
            $table->string('std_course')->nullable();
            $table->double('amount');
            $table->double('amount_due');
            $table->string('transaction_id');
            $table->string('transaction_type')->nullable();
            $table->string('transaction_status')->nullable();
            $table->datetime('transaction_date');
            $table->string('response_code')->nullable();
            $table->string('response_status')->nullable();
            $table->string('flicks_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
