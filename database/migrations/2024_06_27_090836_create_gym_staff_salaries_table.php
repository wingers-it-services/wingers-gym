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
        Schema::create('gym_staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('staff_id');
            $table->string('gym_id')->nullble();
            $table->string('amount')->nullble();
            $table->string('month')->nullble();
            $table->string('year')->nullble();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_staff_salaries');
    }
};
