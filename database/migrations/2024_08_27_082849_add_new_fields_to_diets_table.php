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
        Schema::table('diets', function (Blueprint $table) {
            $table->integer('calories');
            $table->integer('protein');
            $table->integer('carbs');
            $table->integer('fats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diets', function (Blueprint $table) {
            $table->dropColumn('calories'); 
            $table->dropColumn('protein'); 
            $table->dropColumn('carbs'); 
            $table->dropColumn('fats'); 
        });
    }
};
