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
        Schema::create('gym_staffs', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('employee_id');
            $table->string('gym_id');
            $table->string('name');
            $table->string('email');
            $table->string('number');
            $table->string('address');
            $table->string('designation_id');
            $table->string('salary');
            $table->string('image');
            $table->string('joining_date');
            $table->string('blood_group');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_staffs');
    }
};
