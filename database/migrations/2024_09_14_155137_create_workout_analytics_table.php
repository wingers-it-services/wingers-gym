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
        Schema::create('workout_analytics', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->string('month');
            $table->string('year');
            $table->unsignedBigInteger('gym_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workout_id');
            $table->unsignedBigInteger('user_workout_id');
            $table->integer('total_sets');
            $table->integer('total_sets_completed');
            $table->float('percentage');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_analytics');
    }
};
