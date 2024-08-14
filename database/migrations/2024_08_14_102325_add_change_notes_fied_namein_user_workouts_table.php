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
        Schema::table('user_workouts', function (Blueprint $table) {
            $table->renameColumn('notes', 'workout_des');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_workouts', function (Blueprint $table) {
            $table->renameColumn('workout_des', 'notes');
        });
    }
};
