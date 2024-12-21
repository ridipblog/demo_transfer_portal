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
            $table->date('verified_on')->nullable();
            $table->date('noc_generated_on')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->dropColumn('verified_on');
            $table->dropColumn('noc_generated_on');
        });
    }
};
