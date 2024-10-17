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
        Schema::table('goal_wise_workouts', function (Blueprint $table) {
            $table->integer('sets');
            $table->unsignedBigInteger('user_lebel_id')->index();
            $table->integer('reps');
            $table->integer('weight');
            $table->string('day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goal_wise_workouts', function (Blueprint $table) {
            $table->dropColumn('sets');
            $table->dropColumn('reps');
            $table->dropColumn('weight');
            $table->dropColumn('user_lebel_id');
            $table->dropColumn('day');
        });
    }
};
