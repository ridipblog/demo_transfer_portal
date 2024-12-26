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
        Schema::create('authority_rejections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rejected_document_id')->comment('rejected document table id');
            $table->string('document_location')->nullable();
            $table->integer('document_type')->nullable()->comment('same as global variable');
            $table->text('remarks')->nullable()->comment('signle document wise remarks or any remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authority_rejections');
    }
};
