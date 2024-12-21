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
        Schema::create('verification_remarks_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('document_location')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('remarks_by');
            $table->integer('authority_type')->default(1)
            ->comment('1 for verifier , 2 for noc apointing authhority ');
            $table->integer('document_type')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('user_credentials')
                ->onDelete('cascade');
            $table->foreign('remarks_by')
                ->references('id')
                ->on('appointing_authorities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_remarks_documents');
    }
};
