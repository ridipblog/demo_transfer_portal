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
        Schema::create('persional_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('alt_phone_number')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('pan_number')->unique()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('user_credentials')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('caste');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persional_details');
    }
};
