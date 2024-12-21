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
        Schema::create('user_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->integer('profile_verify_status')->default(3)->comment('0 pending,1 accecpted,2 rejected ,3 profile not completed !');
            $table->integer('noc_generate')->default(0)->comment('0 pending,1 generated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_credentials');
    }
};
