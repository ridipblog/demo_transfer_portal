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
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->unsignedBigInteger('verified_by')->after('noc_generate')->nullable();
            $table->unsignedBigInteger('noc_generated_by')->after('verified_by')->nullable();
            $table->foreign('verified_by')
            ->references('id')
            ->on('appointing_authorities')
            ->onDelete('cascade');
            $table->foreign('noc_generated_by')
            ->references('id')
            ->on('appointing_authorities')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->dropColumn('verified_by');
            $table->dropColumn('noc_generated_by');
        });
    }
};
