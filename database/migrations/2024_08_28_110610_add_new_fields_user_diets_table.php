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
        Schema::table('user_diets', function (Blueprint $table) {
            $table->integer('diet_id')->after('user_id');
            $table->string('goal')->after('fats');
            $table->string('meal_type')->after('fats');
            $table->longText('diet_description')->after('fats');
            $table->longText('alternative_diet_description')->after('fats');
            $table->boolean('is_completed')->default('0')->after('fats');
            $table->dropColumn('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_diets', function (Blueprint $table) {
            $table->dropColumn('diet_id'); 
            $table->dropColumn('goal'); 
            $table->dropColumn('meal_type'); 
            $table->dropColumn('diet_description'); 
            $table->dropColumn('alternative_diet_description'); 
            $table->dropColumn('is_completed');
            $table->longText('notes');
        });
    }
};
