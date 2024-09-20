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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('ad_title')->after('banner')->nullable();
            $table->string('ad_link')->after('ad_title')->nullable();
            $table->string('type')->after('ad_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('ad_title'); 
            $table->dropColumn('ad_link'); 
            $table->dropColumn('type'); 
        });
    }
};
