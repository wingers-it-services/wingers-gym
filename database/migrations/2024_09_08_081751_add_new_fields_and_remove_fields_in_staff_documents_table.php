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
            $table->string('document_name')->after('gym_id');
            $table->string('file')->after('gym_id');
            $table->integer('status')->after('gym_id');
            $table->dropColumn('aadhaar_card');
            $table->dropColumn('cancel_cheque');
            $table->dropColumn('other');
            $table->dropColumn('pan_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_documents', function (Blueprint $table) {
           $table->dropColumn('document_name');
           $table->dropColumn('file');
           $table->dropColumn('status');
           $table->longText('aadhaar_card');
           $table->longText('pan_card');
           $table->longText('cancel_cheque');
           $table->longText('other');
        });
    }
};
