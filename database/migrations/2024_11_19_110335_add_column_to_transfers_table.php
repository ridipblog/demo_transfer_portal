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
            // $table->string('2nd_recommend_remarks')->nullable();
            // $table->integer('2nd_recommended_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transafers', function (Blueprint $table) {
            //
        });
    }
};