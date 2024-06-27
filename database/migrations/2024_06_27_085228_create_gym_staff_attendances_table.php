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
        Schema::create('gym_staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('gym_staff_id');
            $table->string('gym_id')->nullble();
            $table->string('month')->nullble();
            $table->string('year')->nullble();
            $table->string('day1')->nullble();
            $table->string('day2')->nullble();
            $table->string('day3')->nullble();
            $table->string('day4')->nullble();
            $table->string('day5')->nullble();
            $table->string('day6')->nullble();
            $table->string('day7')->nullble();
            $table->string('day8')->nullble();
            $table->string('day9')->nullble();
            $table->string('day10')->nullble();
            $table->string('day11')->nullble();
            $table->string('day12')->nullble();
            $table->string('day13')->nullble();
            $table->string('day14')->nullble();
            $table->string('day15')->nullble();
            $table->string('day16')->nullble();
            $table->string('day17')->nullble();
            $table->string('day18')->nullble();
            $table->string('day19')->nullble();
            $table->string('day20')->nullble();
            $table->string('day21')->nullble();
            $table->string('day22')->nullble();
            $table->string('day23')->nullble();
            $table->string('day24')->nullble();
            $table->string('day25')->nullble();
            $table->string('day26')->nullble();
            $table->string('day27')->nullble();
            $table->string('day28')->nullble();
            $table->string('day29')->nullble();
            $table->string('day30')->nullble();
            $table->string('day31')->nullble();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_staff_attendances');
    }
};
