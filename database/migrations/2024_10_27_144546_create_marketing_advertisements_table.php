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
        Schema::create('marketing_advertisements', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->integer('advertisement_type');
            $table->integer('targetted_no');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->longText('address');
            $table->string('email');
            $table->string('phone_no');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_advertisements');
    }
};
