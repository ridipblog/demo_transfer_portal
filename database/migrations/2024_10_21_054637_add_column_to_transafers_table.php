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
            // $table->integer('jto_generate_status')->default(0)->after('approved_by');
            // $table->date('approved_on')->nullable()->after('jto_generate_status');
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