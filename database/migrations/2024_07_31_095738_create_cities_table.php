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
        Schema::create('cities', function (Blueprint $table) {
            $table->id(); 
             $table->unsignedBigInteger('countryId');
            $table->unsignedBigInteger('stateId');
            $table->string('name');
            $table->timestamps();

            $table->foreign('countryId')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('stateId')->references('id')->on('states')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
