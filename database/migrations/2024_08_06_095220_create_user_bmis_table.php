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
        Schema::create('user_bmis', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->integer('gym_id');
            $table->integer('user_id');
            $table->float('height');
            $table->float('weight');
            $table->float('bmi');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bmis');
    }
};
