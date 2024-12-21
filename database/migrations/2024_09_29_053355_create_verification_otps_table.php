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
        Schema::create('verification_otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->dateTime('expire_time');
            $table->integer('otp');
            $table->integer('is_used')->comment('1 for used 0 for unused');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_otps');
    }
};
