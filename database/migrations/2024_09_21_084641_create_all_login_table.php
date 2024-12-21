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
        Schema::create('all_login', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('user_type');
            $table->string('phone');
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->string('status')->default(1)->comment('1 for active user and 2 for deactive ');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_login');
    }
};
