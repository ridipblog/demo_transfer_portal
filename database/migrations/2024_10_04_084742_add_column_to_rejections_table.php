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
        Schema::table('rejections', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('role')->nullable();
            $table->foreign('created_by')
                ->references('id')
                ->on('appointing_authorities')
                ->onDelete('cascade');
            $table->foreign('role')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rejections', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('role');
        });
    }
};
