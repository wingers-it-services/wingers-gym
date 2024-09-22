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
        Schema::create('user_inquiries', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('gym_id')->index();
            $table->longText('reason');
            $table->longText('description');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inquiries');
    }
};
