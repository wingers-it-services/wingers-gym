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
        Schema::table('cloths', function (Blueprint $table) {
            $table->bigInteger('gym_id')->before('name');
            $table->renameColumn('string', 'size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cloths', function (Blueprint $table) {
            $table->dropColumn('gym_id'); 
            $table->renameColumn('size', 'string');
            //
        });
    }
};
