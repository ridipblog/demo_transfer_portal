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
        Schema::table('transafers', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable()->after('approver_remarks');
            $table->foreign('approved_by')
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
        Schema::table('transafers', function (Blueprint $table) {
            $table->dropColumn('approved_by');
        });
    }
};
