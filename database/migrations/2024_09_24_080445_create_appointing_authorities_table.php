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
        Schema::create('appointing_authorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->string('phone');
            $table->integer('department');
            $table->string('office')->nullable();
            $table->integer('district')->nullable();
            $table->timestamps();
            // $table->foreign('department')
            //     ->references('id')
            //     ->on('deptartments')
            //     ->onDelete('cascade');
            // $table->foreign('district')
            //     ->references('id')
            //     ->on('districts')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointing_authorities');
    }
};
