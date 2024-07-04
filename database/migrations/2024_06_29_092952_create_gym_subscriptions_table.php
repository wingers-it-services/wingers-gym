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
        Schema::create('gym_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('status');
            $table->string('subscription_name');
            $table->string('amount');
            $table->date('start_date');
            $table->string('validity');
            $table->string('description');
            $table->string('gym_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_subscriptions');
    }
};
