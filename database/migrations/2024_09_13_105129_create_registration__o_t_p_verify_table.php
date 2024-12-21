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
        Schema::create('registration__o_t_p_verify', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->integer('OTP');
            $table->dateTime('expire_time');
            $table->integer('is_used')->default(1)->comment('1 for not used and 2 is OTP used ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration__o_t_p_verify');
    }
};
