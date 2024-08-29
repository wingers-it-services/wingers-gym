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
        Schema::create('current_user_diets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->integer('gym_id');
            $table->integer('user_id');
            $table->integer('diet_id');
            $table->string('current_day');
            $table->boolean('is_completed')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_user_diets');
    }
};
