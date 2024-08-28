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
        Schema::table('staff_documents', function (Blueprint $table) {
            $table->longText('pan_card')->after('aadhaar_card');
            $table->longText('cancel_cheque')->after('aadhaar_card');
            $table->longText('other')->after('aadhaar_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_documents', function (Blueprint $table) {
            $table->dropColumn('pan_card'); 
            $table->dropColumn('cancel_cheque'); 
            $table->dropColumn('other'); 
        });
    }
};
