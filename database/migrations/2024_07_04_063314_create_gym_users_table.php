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
        Schema::create('gym_users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('employee_id');
            $table->string('gym_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('phone_no');
            $table->string('member_number');
            $table->string('subscription_id');
            $table->string('gender');
            $table->string('blood_group');
            $table->string('image');
            $table->string('joining_date');
            $table->string('address');
            $table->string('country');
            $table->string('state');
            $table->string('zip_code');
            $table->boolean('is_email_verified')->default(0);
            $table->boolean('is_phone_no_verified')->default(0);
            $table->integer('profile_status')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_users');
    }
};
