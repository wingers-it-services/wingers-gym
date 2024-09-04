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
        Schema::create('user_subscription_payments', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->string('orderId')->unique();
            $table->string('name')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('gym_id')->nullable();
            $table->bigInteger('coupon_id')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('response_code')->nullable();
            $table->string('merchantId')->nullable();
            $table->string('transectionId')->nullable();
            $table->float('amount')->default(0);
            $table->unsignedBigInteger('subscription_id');
            $table->float('total')->default(0);
            $table->string('providerReferenceId')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscription_payments');
    }
};
