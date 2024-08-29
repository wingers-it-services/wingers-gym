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
        Schema::create('current_day_workouts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('workout_id')->index();
            $table->unsignedBigInteger('gym_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('details');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_day_workouts');
    }
};
