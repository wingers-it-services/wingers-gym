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
        Schema::table('current_day_workouts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_workout_id')->after('workout_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_day_workouts', function (Blueprint $table) {   
            $table->dropColumn('user_workout_id'); 
        });
    }
};
