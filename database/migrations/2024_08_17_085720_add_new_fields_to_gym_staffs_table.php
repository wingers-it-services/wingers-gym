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
        Schema::table('gym_staffs', function (Blueprint $table) {
            $table->string('gender')->after('name')->nullable();
            $table->integer('experience')->after('joining_date')->nullable();
            $table->date('dob')->after('experience')->nullable();
            $table->string('whatsapp_no')->after('dob')->nullable();
            $table->double('fees')->after('whatsapp_no')->default(0);
            $table->double('staff_commission')->after('fees')->default(0);
            $table->double('gym_commission')->after('staff_commission')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_staffs', function (Blueprint $table) {
            $table->dropColumn('gender'); 
            $table->dropColumn('experience'); 
            $table->dropColumn('dob'); 
            $table->dropColumn('whatsapp_no'); 
            $table->dropColumn('fees'); 
            $table->dropColumn('gym_commission'); 
            $table->dropColumn('staff_commission'); 
        });
    }
};
