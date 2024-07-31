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
        Schema::table('gyms', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('username')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('web_link')->nullable();
            $table->string('gym_type')->nullable();
            $table->string('face_link')->nullable();
            $table->string('insta_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gyms', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('username');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('web_link')->nullable();
            $table->dropColumn('gym_type');
            $table->dropColumn('face_link')->nullable();
            $table->dropColumn('insta_link')->nullable();
        });
    }
};
