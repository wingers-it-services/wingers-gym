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
            $table->string('targeted_body_part')->after('workout_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_day_workouts', function (Blueprint $table) {
            $table->dropColumn('targeted_body_part'); 
        });
    }
};
