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
        Schema::create('user_subscription_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->integer('user_id');
            $table->integer('subscription_id');
            $table->integer('original_transaction_id');
            $table->date('joining_date');
            $table->date('end_date');
            $table->integer('status');
            $table->string('amount');
            $table->integer('coupon_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscription_histories');
    }
};
