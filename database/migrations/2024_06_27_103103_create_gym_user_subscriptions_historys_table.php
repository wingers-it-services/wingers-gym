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
        Schema::create('gym_user_subscriptions_historys', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('gym_id');
            $table->string('user_id')->nullble();
            $table->string('subscription_id')->nullble();
            $table->string('price');
            $table->string('buy_date');
            $table->string('expire_date');
            $table->string('isActive');
            $table->string('coupon_code');
            $table->string('original_transaction_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_user_subscriptions_historys');
    }
};
