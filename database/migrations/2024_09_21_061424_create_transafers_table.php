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
        Schema::create('transafers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('target_employee_id');
            $table->integer('request_status')->default(0)->comment('0 pending,1 accepted,2 rejected ');
            $table->string('remarks')->nullable();
            $table->foreign('employee_id')
                ->references('id')
                ->on('user_credentials')
                ->onDelete('cascade');
            $table->foreign('target_employee_id')
                ->references('id')
                ->on('user_credentials')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transafers');
    }
};
