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
        Schema::table('gym_staff_aseets', function (Blueprint $table) {
            $table->integer('gym_id')->change();
            $table->integer('staff_id')->change();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_staff_aseets', function (Blueprint $table) {
            $table->string('gym_id')->change();
            $table->string('staff_id')->change();

        });
    }
};
